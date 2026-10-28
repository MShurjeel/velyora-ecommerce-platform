<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Featured Products for the curated section
        $featuredProducts = Product::with(['category', 'images', 'reviews'])
            ->where('status', 'active')
            ->where('is_featured', 1)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with(['category', 'images', 'reviews'])
                ->where('status', 'active')
                ->orderBy('id', 'desc')
                ->take(4)
                ->get();
        }

        // 2. Trending Products (active products, non-hardcoded)
        $trendingProducts = Product::with(['category', 'images'])
            ->where('status', 'active')
            ->whereNotIn('id', $featuredProducts->pluck('id'))
            ->orderBy('id', 'desc')
            ->take(3)
            ->get();

        if ($trendingProducts->isEmpty()) {
            $trendingProducts = Product::with(['category', 'images'])
                ->where('status', 'active')
                ->take(3)
                ->get();
        }

        // 3. Hero Product (Featured active product or first active product)
        $heroProduct = Product::with(['category', 'images'])
            ->where('status', 'active')
            ->where('is_featured', 1)
            ->first() ?? Product::with(['category', 'images'])->where('status', 'active')->first();

        // 4. Categories for the category grid
        $categories = Category::where('status', 'active')->orderBy('id', 'asc')->get();

        return view('pages.home', compact('featuredProducts', 'trendingProducts', 'heroProduct', 'categories'));
    }
}
