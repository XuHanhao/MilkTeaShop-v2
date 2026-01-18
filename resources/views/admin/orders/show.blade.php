@extends('layouts.admin')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold">Order Number: {{ $order->code }}</h2>
                <p class="text-sm text-gray-600 mt-1">Order Time: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
            </div>
            <span class="px-3 py-1 text-sm rounded-full 
                @if($order->status == 'completed') bg-green-100 text-green-800
                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                @elseif($order->status == 'preparing') bg-yellow-100 text-yellow-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ $order->status }}
            </span>
        </div>
    </div>

    <div class="px-6 py-4">
        <h3 class="text-lg font-semibold mb-4">Order Items</h3>
        <div class="space-y-4">
            @foreach($order->items as $item)
            <div class="flex items-center justify-between border-b pb-4">
                <div>
                    <h4 class="font-medium">{{ $item->product->name ?? 'Product Deleted' }}</h4>
                    <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                </div>
                <p class="text-sm font-medium">¥{{ number_format($item->unit_price * $item->quantity, 2) }}</p>
            </div>
            @endforeach
        </div>

        <div class="mt-6 pt-4 border-t">
            <div class="flex justify-between text-lg font-semibold">
                <span>Total:</span>
                <span>¥{{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>
    </div>

    @if(in_array($order->status, ['pending', 'confirmed', 'preparing']))
    <div class="px-6 py-4 bg-gray-50 border-t">
        <h3 class="text-lg font-semibold mb-4">Update Order Status</h3>
        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
            @csrf
            <div class="flex gap-4">
                <select name="status" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                    <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Ready</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Update Status
                    </button>
            </div>
        </form>
    </div>
    @endif

    <div class="px-6 py-4 bg-gray-50 border-t">
        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800">
            ← Back to Order List
        </a>
    </div>
</div>
@endsection

