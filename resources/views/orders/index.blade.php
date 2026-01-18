@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-primary-700 mb-8">My Orders</h1>

    @if($orders->count() > 0)
    <div class="bg-white rounded-xl shadow-soft overflow-hidden">
        <ul class="divide-y divide-gray-100">
            @foreach($orders as $order)
            <li>
                <a href="{{ route('orders.show', $order) }}" class="block hover:bg-primary-50 transition-all duration-200">
                    <div class="px-8 py-6">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <p class="text-sm font-semibold text-primary-700">
                                    Order Number: {{ $order->code }}
                                </p>
                                <span class="px-3 py-1 text-xs font-medium rounded-full 
                                    @if($order->status == 'completed') bg-accent-100 text-accent-700
                                    @elseif($order->status == 'cancelled') bg-secondary-100 text-secondary-700
                                    @elseif($order->status == 'preparing') bg-primary-100 text-primary-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </div>
                            <div class="text-right w-full md:w-auto">
                                <p class="text-lg font-bold text-primary-600">
                                    ¥{{ number_format($order->total_amount, 2) }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $order->created_at->format('Y-m-d H:i') }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-600">
                                    Total {{ $order->items->count() }} items
                                </p>
                                <span class="text-sm text-primary-600 font-medium hover:text-primary-700 transition-colors duration-200">
                                    View Details →
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-8">
        {{ $orders->links() }}
    </div>
    @else
    <div class="text-center py-16 bg-white rounded-xl shadow-soft">
        <svg class="w-16 h-16 text-primary-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
        </svg>
        <p class="text-gray-500 text-lg mb-6">No orders yet</p>
        <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            Go Shopping
        </a>
    </div>
    @endif
</div>
@endsection

