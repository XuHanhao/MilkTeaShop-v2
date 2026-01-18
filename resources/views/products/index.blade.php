@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-72">
            <div class="bg-white rounded-xl shadow-soft p-5">
                <h3 class="font-semibold text-lg text-primary-700 mb-5">Category Filters</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('products.index') }}" class="block px-4 py-3 rounded-lg hover:bg-primary-50 transition-colors duration-200 {{ !request('category_id') ? 'bg-primary-100 text-primary-700 font-medium' : 'text-gray-700' }}">
                            All
                        </a>
                    </li>
                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="block px-4 py-3 rounded-lg hover:bg-primary-50 transition-colors duration-200 {{ request('category_id') == $category->id ? 'bg-primary-100 text-primary-700 font-medium' : 'text-gray-700' }}">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Products Grid -->
        <main class="flex-1">
            <h1 class="text-3xl font-bold text-primary-700 mb-8">Products</h1>
            
            @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                <a href="{{ route('products.show', $product) }}" class="block bg-white rounded-xl shadow-soft overflow-hidden transition-all duration-300 hover:shadow-elevated hover:-translate-y-1">
                    @if($product->image)
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-52 object-cover transition-transform duration-500 hover:scale-105">
                    @else
                    <div class="w-full h-52 bg-primary-50 flex items-center justify-center transition-colors duration-200 hover:bg-primary-100">
                        <span class="text-primary-400">No Image Available</span>
                    </div>
                    @endif
                    <div class="p-5">
                        <h3 class="font-semibold text-lg text-primary-700 mb-2 hover:text-primary-600 transition-colors duration-200">{{ $product->name }}</h3>
                        @if($product->description)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                        @endif
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-primary-600">¥{{ number_format($product->base_price, 2) }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center py-16 bg-white rounded-xl shadow-soft">
                <p class="text-gray-500 text-lg">No products available</p>
                <a href="{{ route('products.index') }}" class="mt-4 inline-block text-primary-600 hover:text-primary-700 font-medium transition-colors duration-200">
                    View all products
                </a>
            </div>
            @endif
        </main>
    </div>
</div>
@endsection

