<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'active')
            ->orderBy('sort_order')
            ->with(['products' => function ($query) {
                $query->where('status', 'active')->orderBy('sort_order')->limit(6);
            }])
            ->get();

        $announcements = \App\Models\Announcement::where('status', 'active')
            ->where('target_audience', 'customer')
            ->where(function ($query) {
                $query->whereNull('start_at')
                    ->orWhere('start_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_at')
                    ->orWhere('end_at', '>=', now());
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('home', compact('categories', 'announcements'));
    }
}

