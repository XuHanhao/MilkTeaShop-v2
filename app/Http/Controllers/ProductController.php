<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('optionValues')->where('status', 'active');

        if ($request->has('category_id') && $request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        $products = $query->orderBy('sort_order')->paginate(12);
        $categories = Category::where('status', 'active')->orderBy('sort_order')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('optionValues', 'category');
        
        return view('products.show', compact('product'));
    }
}

