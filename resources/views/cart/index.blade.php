@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-primary-700 mb-8">Cart</h1>

    @if (empty($cart))
        <div class="bg-white rounded-xl shadow-soft p-10 text-center">
            <p class="text-gray-500 text-lg mb-6">Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Go Shopping
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-soft overflow-hidden mb-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-primary-50">
                    <tr>
                        <th scope="col" class="px-8 py-4 text-left text-sm font-medium text-primary-700 uppercase tracking-wider">Product Info</th>
                    <th scope="col" class="px-8 py-4 text-left text-sm font-medium text-primary-700 uppercase tracking-wider">Quantity</th>
                    <th scope="col" class="px-8 py-4 text-left text-sm font-medium text-primary-700 uppercase tracking-wider">Unit Price</th>
                    <th scope="col" class="px-8 py-4 text-left text-sm font-medium text-primary-700 uppercase tracking-wider">Subtotal</th>
                    <th scope="col" class="px-8 py-4 text-left text-sm font-medium text-primary-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($cart as $index => $item)
                        <tr class="hover:bg-primary-50 transition-colors duration-200">
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if ($item['image'])
                                        <div class="flex-shrink-0 h-20 w-20">
                                            <img class="h-20 w-20 object-cover rounded-lg shadow-sm" src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 h-20 w-20 bg-primary-100 rounded-lg flex items-center justify-center">
                                            <span class="text-primary-400">No Image Available</span>
                                        </div>
                                    @endif
                                    <div class="ml-6">
                                        <div class="text-base font-semibold text-primary-700">{{ $item['name'] }}</div>
                                        @if (!empty($item['selected_options']))
                                            <div class="text-xs text-gray-500 mt-2 space-y-1">
                                                @foreach ($item['selected_options'] as $optionType => $optionValue)
                                                    <span class="inline-block bg-primary-50 px-2 py-1 rounded-full">
                                                        {{ ucfirst($optionType) }}: {{ $optionValue }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <form action="{{ route('cart.update', $index) }}" method="POST">
                                    @csrf
                                    <div class="flex items-center">
                                        <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" 
                                               class="w-20 border border-primary-200 rounded-lg px-3 py-2 text-center focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                        <button type="submit" class="ml-3 px-4 py-2 text-sm bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="text-base font-medium text-gray-900">¥{{ number_format($item['unit_price'], 2) }}</div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <div class="text-base font-bold text-primary-600">¥{{ number_format($item['total_price'], 2) }}</div>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-sm">
                                <form action="{{ route('cart.remove', $index) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-secondary-600 hover:text-secondary-800 transition-colors duration-200">
                                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <div>
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Clear Cart
                    </button>
                </form>
            </div>
            <div class="w-full sm:w-auto flex flex-col items-end">
                <div class="text-lg font-medium text-gray-800 mb-3">
                    Total: <span class="text-3xl font-bold text-primary-700">¥{{ number_format($totalAmount, 2) }}</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="inline-flex items-center px-8 py-4 border border-transparent text-base font-medium rounded-lg shadow-md text-white bg-primary-600 hover:bg-primary-700 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @endif
</div>
@endsection