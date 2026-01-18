<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty, cannot checkout');
        }

        $totalAmount = array_sum(array_map(function($item) {
            return $item['total_price'];
        }, $cart));

        // Get user's delivery address
        $user = auth()->user();
        $deliveryAddresses = [];
        if ($user->member) {
            $deliveryAddresses = $user->member->address_book ?? [];
        }

        return view('checkout.index', compact('cart', 'totalAmount', 'deliveryAddresses'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty, cannot checkout');
        }

        $validated = $request->validate([
            'delivery_type' => ['required', 'in:pickup,delivery'],
            'notes' => ['nullable', 'string'],
        ]);

        // Only validate address when delivery is selected
        if ($request->delivery_type === 'delivery') {
            $request->validate([
                'delivery_address' => ['required', 'array'],
                'delivery_address.name' => ['required', 'string'],
                'delivery_address.phone' => ['required', 'string'],
                'delivery_address.province' => ['required', 'string'],
                'delivery_address.city' => ['required', 'string'],
                'delivery_address.district' => ['required', 'string'],
                'delivery_address.detail' => ['required', 'string'],
            ]);
            
            // Merge address validation results into validated array
            $validated['delivery_address'] = $request->validated()['delivery_address'];
        } else {
            // Set to empty array in pickup mode
            $validated['delivery_address'] = null;
        }

        // Create order
        $order = $this->createOrder($validated, $cart);

        // Clear cart
        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Order created successfully');
    }

    protected function createOrder(array $validated, array $cart)
    {
        $user = auth()->user();
        $totalAmount = array_sum(array_map(function($item) {
            return $item['total_price'];
        }, $cart));

        // Generate order number
        $orderCode = 'ORDER' . date('YmdHis') . Str::random(6);

        // Create order
        $order = Order::create([
            'code' => $orderCode,
            'user_id' => $user->id,
            'status' => 'pending',
            'delivery_type' => $validated['delivery_type'],
            'pay_status' => 'unpaid',
            'channel' => 'web',
            'subtotal_amount' => $totalAmount,
            'discount_amount' => 0,
            'delivery_fee' => $validated['delivery_type'] === 'delivery' ? 5.00 : 0,
            'total_amount' => $totalAmount + ($validated['delivery_type'] === 'delivery' ? 5.00 : 0),
            'delivery_address' => $validated['delivery_address'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Create order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'product_image' => $item['image'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['total_price'],
                'selected_options' => $item['selected_options'],
            ]);

            // Update product stock
            $product = Product::find($item['id']);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        return $order;
    }
}