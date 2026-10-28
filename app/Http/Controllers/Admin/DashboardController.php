<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalCustomers = User::count();

        $recentOrders = Order::with('items')->latest()->take(5)->get();
        $featuredProducts = Product::with('category')->where('is_featured', 1)->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'totalCategories',
            'totalCustomers',
            'recentOrders',
            'featuredProducts'
        ));
    }
}

