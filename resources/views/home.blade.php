@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Announcements -->
    @if($announcements->count() > 0)
    <div class="mb-8 bg-primary-50 border border-primary-200 rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-primary-700 mb-4">Announcements</h2>
        <div class="space-y-4">
            @foreach($announcements as $announcement)
            <div class="flex items-start p-3 bg-white rounded-lg hover:shadow-soft transition-shadow">
                <span class="text-primary-500 mr-3 mt-1">•</span>
                <div>
                    <h3 class="font-medium text-primary-700">{{ $announcement->title }}</h3>
                    @if($announcement->content)
                    <p class="text-sm text-gray-600 mt-1">{{ $announcement->content }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Categories and Products -->
    @foreach($categories as $category)
    <div class="mb-16">
        <h2 class="text-2xl font-bold text-primary-700 mb-6 flex items-center">
            {{ $category->name }}
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($category->products as $product)
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
                        <span class="bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-sm font-medium">
                            View Details
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @if($category->products->count() > 0)
       
        @endif
    </div>
    @endforeach
</div>
@endsection

