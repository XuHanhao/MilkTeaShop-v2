<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $totalAmount = array_sum(array_map(function($item) {
            return $item['total_price'];
        }, $cart));

        return view('cart.index', compact('cart', 'totalAmount'));
    }

    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'. $product->stock],
            'selected_options' => ['nullable', 'array'],
        ]);

        $cart = session()->get('cart', []);
        $cartItem = [
            'id' => $product->id,
            'name' => $product->name,
            'image' => $product->image,
            'quantity' => $validated['quantity'],
            'unit_price' => $product->base_price,
            'selected_options' => $validated['selected_options'] ?? [],
        ];

        // Calculate total price
        $cartItem['total_price'] = $cartItem['unit_price'] * $cartItem['quantity'];

        // Check if the same product already exists (including same options)
        $existingKey = null;
        foreach ($cart as $key => $item) {
            if ($item['id'] === $product->id && $item['selected_options'] === $cartItem['selected_options']) {
                $existingKey = $key;
                break;
            }
        }

        if ($existingKey !== null) {
            // Update existing product quantity
            $cart[$existingKey]['quantity'] += $cartItem['quantity'];
            $cart[$existingKey]['total_price'] = $cart[$existingKey]['unit_price'] * $cart[$existingKey]['quantity'];
        } else {
            // Add new product
            $cart[] = $cartItem;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart');
    }

    public function update(Request $request, $index)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$index])) {
            $product = Product::find($cart[$index]['id']);
            if ($validated['quantity'] > $product->stock) {
                return redirect()->route('cart.index')->with('error', 'Insufficient stock');
            }

            $cart[$index]['quantity'] = $validated['quantity'];
            $cart[$index]['total_price'] = $cart[$index]['unit_price'] * $cart[$index]['quantity'];
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated');
    }

    public function remove($index)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$index])) {
            unset($cart[$index]);
            // Re-index array
            $cart = array_values($cart);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared');
    }
}