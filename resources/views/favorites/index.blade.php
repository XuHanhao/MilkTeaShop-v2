@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">My Favorites</h1>

    @if($favorites->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($favorites as $favorite)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
            @if($favorite->product->image)
            <img src="{{ $favorite->product->image }}" alt="{{ $favorite->product->name }}" class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <span class="text-gray-400">No Image</span>
            </div>
            @endif
            <div class="p-4">
                <h3 class="font-semibold text-lg mb-2">{{ $favorite->product->name }}</h3>
                <div class="flex items-center justify-between">
                    <span class="text-xl font-bold text-red-600">¥{{ number_format($favorite->product->base_price, 2) }}</span>
                    <div class="flex gap-2">
                        <a href="{{ route('products.show', $favorite->product) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                        View
                    </a>
                        <form action="{{ route('favorites.destroy', $favorite->product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $favorites->links() }}
    </div>
    @else
    <div class="text-center py-12">
        <p class="text-gray-500">No favorites yet</p>
        <a href="{{ route('products.index') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-800">
            Browse Products →
        </a>
    </div>
    @endif
</div>
@endsection

