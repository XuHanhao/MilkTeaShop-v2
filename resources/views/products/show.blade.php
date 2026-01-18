@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-soft overflow-hidden">
        <div class="md:flex">
            <!-- Product Image -->
            <div class="md:w-1/2">
                @if($product->image)
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                @else
                <div class="w-full h-96 bg-primary-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="md:w-1/2 p-8">
                <h1 class="text-3xl font-bold text-primary-700 mb-4">{{ $product->name }}</h1>
                
                @if($product->category)
                <p class="text-gray-600 mb-4">
                    <span class="text-sm">Category:</span>
                    <a href="{{ route('products.index', ['category_id' => $product->category->id]) }}" class="text-primary-600 hover:text-primary-700 transition-colors duration-200">
                        {{ $product->category->name }}
                    </a>
                </p>
                @endif

                <div class="mb-6">
                    <span class="text-4xl font-bold text-secondary-600">¥{{ number_format($product->base_price, 2) }}</span>
                </div>

                @if($product->description)
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-primary-700 mb-2">Product Description</h2>
                    <p class="text-gray-700">{{ $product->description }}</p>
                </div>
                @endif

                @if($product->optionValues->count() > 0)
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-primary-700 mb-4">Available Options</h2>
                    <div class="space-y-4">
                        @foreach($product->optionValues->groupBy('type') as $type => $options)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ ucfirst($type) }}</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($options as $option)
                                <span class="px-3 py-1 bg-primary-50 rounded-lg text-sm text-gray-700 hover:bg-primary-100 transition-colors duration-200">
                                    {{ $option->label }}
                                    @if($option->extra_price > 0)
                                    <span class="text-secondary-600">+¥{{ number_format($option->extra_price, 2) }}</span>
                                    @endif
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-8">
                    @csrf
                    <div class="flex items-center gap-4 mb-6">
                        <label class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1" 
                               class="w-20 border border-gray-300 rounded-lg px-3 py-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                    </div>

                    <!-- Product Option Selection -->
                    @if($product->optionValues->count() > 0)
                        @foreach($product->optionValues->groupBy('type') as $type => $options)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ ucfirst($type) }}</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($options as $option)
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="selected_options[{{ $type }}]" 
                                                   value="{{ $option->label }}" 
                                                   @if($option->is_default) checked @endif 
                                                   class="form-radio text-primary-600 focus:ring-primary-500">
                                            <span class="ml-2 px-3 py-1 bg-primary-50 rounded-lg text-sm text-gray-700 hover:bg-primary-100 transition-colors duration-200">
                                                {{ $option->label }}
                                                @if($option->extra_price > 0)
                                                <span class="text-secondary-600">+¥{{ number_format($option->extra_price, 2) }}</span>
                                                @endif
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-primary-500 text-white px-8 py-3 rounded-lg hover:bg-primary-600 font-medium transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5">
                            Add to Cart
                        </button>
                        <a href="{{ route('products.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition-all duration-200">
                            Back to List
                        </a>
                    </div>
                </form>

                <!-- Favorite Button -->
                @auth
                <div class="mt-6">
                    <form action="{{ route('favorites.store') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="bg-secondary-500 text-white px-6 py-2.5 rounded-lg hover:bg-secondary-600 transition-all duration-200 hover:shadow-md">
                            Add to Favorites
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection

