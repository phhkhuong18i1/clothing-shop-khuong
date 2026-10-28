<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(), 'publishedCount' => Product::where('is_published', true)->count(),
            'categoryCount' => Category::count(), 'lowStockCount' => Product::where('stock_quantity', '<', 5)->count(),
            'recentProducts' => Product::with('category')->latest()->take(6)->get(),
        ]);
    }
}
