@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-soft overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-700">Order Details</h1>
                    <div class="flex items-center gap-4 mt-2">
                        <p class="text-sm text-gray-600">Order Number: {{ $order->code }}</p>
                        <p class="text-sm text-gray-600">Order Time: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>
                <span class="px-4 py-2 text-sm font-medium rounded-full 
                    @if($order->status == 'completed') bg-accent-100 text-accent-700
                    @elseif($order->status == 'cancelled') bg-secondary-100 text-secondary-700
                    @elseif($order->status == 'preparing') bg-primary-100 text-primary-700
                    @else bg-gray-100 text-gray-700
                    @endif">
                    {{ $order->status }}
                </span>
            </div>
        </div>

        <div class="px-8 py-6">
            <h2 class="text-lg font-semibold text-primary-700 mb-6">Order Items</h2>
            <div class="space-y-6">
                @foreach($order->items as $item)
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 pb-6 border-b border-gray-100 last:border-b-0">
                    <div class="flex items-center w-full md:w-auto">
                        @if($item->product && $item->product->image)
                        <div class="flex-shrink-0 h-16 w-16">
                            <img class="h-16 w-16 object-cover rounded-lg shadow-sm" src="{{ $item->product->image }}" alt="{{ $item->product->name }}">
                        </div>
                        @else
                        <div class="flex-shrink-0 h-16 w-16 bg-primary-100 rounded-lg flex items-center justify-center">
                            <span class="text-primary-400">No Image</span>
                        </div>
                        @endif
                        <div class="ml-5 w-full">
                            <h3 class="text-base font-semibold text-primary-700">{{ $item->product->name ?? 'Product Deleted' }}</h3>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="bg-primary-50 text-primary-700 px-2 py-1 rounded-full text-xs font-medium">
                                    Quantity: {{ $item->quantity }}
                                </span>
                                @if($item->options_json)
                                <span class="bg-primary-50 text-primary-700 px-2 py-1 rounded-full text-xs font-medium">
                                    Options: {{ json_encode($item->options_json, JSON_UNESCAPED_UNICODE) }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <p class="text-xl font-bold text-primary-600 md:ml-auto">¥{{ number_format($item->unit_price * $item->quantity, 2) }}</p>
                </div>
                @endforeach
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 bg-primary-50 rounded-lg p-5">
                <div class="flex justify-between items-center text-lg font-semibold">
                    <span class="text-primary-700">Total:</span>
                    <span class="text-2xl font-bold text-primary-600">¥{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="px-8 py-6 bg-primary-50 border-t">
            <a href="{{ route('orders.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium rounded-lg text-primary-700 bg-primary-100 hover:bg-primary-200 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Order List
            </a>
        </div>
    </div>
</div>
@endsection

