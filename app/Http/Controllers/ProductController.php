<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductCatalogService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->query('category', '');
        $searchQuery = trim($request->query('search', $request->query('q', '')));
        $sort = $request->query('sort', 'featured');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $inStock = $request->query('in_stock');
        $filter = $request->query('filter', '');

        // Fetch categories with active products count
        $categories = Category::withCount(['products' => function ($query) {
            $query->where('status', 'active');
        }])->get();

        $totalProducts = Product::where('status', 'active')->count();

        // Build query
        $query = Product::with(['category', 'images', 'reviews'])->where('status', 'active');

        // Filter by category slug
        if ($selectedCategory !== '') {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        // Filter by search query
        if ($searchQuery !== '') {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('name', 'like', "%{$searchQuery}%")
                  ->orWhere('description', 'like', "%{$searchQuery}%")
                  ->orWhereHas('category', function ($cq) use ($searchQuery) {
                      $cq->where('name', 'like', "%{$searchQuery}%");
                  });
            });
        }

        // Filter by price range
        if (is_numeric($minPrice)) {
            $query->whereRaw('COALESCE(sale_price, price) >= ?', [(float) $minPrice]);
        }
        if (is_numeric($maxPrice)) {
            $query->whereRaw('COALESCE(sale_price, price) <= ?', [(float) $maxPrice]);
        }

        // Filter by stock
        if ($inStock === '1' || $inStock === 'true') {
            $query->where('stock_qty', '>', 0);
        }

        // Filter deals / on sale
        if ($filter === 'sale' || $request->query('on_sale') === '1') {
            $query->whereNotNull('sale_price')->whereRaw('sale_price < price');
        }

        // Sorting
        if ($sort === 'price-low') {
            $query->orderByRaw('COALESCE(sale_price, price) ASC');
        } elseif ($sort === 'price-high') {
            $query->orderByRaw('COALESCE(sale_price, price) DESC');
        } elseif ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
        }

        $filteredProducts = $query->get();

        return view('pages.products', compact(
            'filteredProducts',
            'categories',
            'totalProducts',
            'selectedCategory',
            'searchQuery',
            'sort',
            'minPrice',
            'maxPrice',
            'inStock',
            'filter'
        ));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'images'])
            ->where('status', 'active')
            ->findOrFail($id);

        // Fetch related products from same category
        $relatedProducts = Product::with(['category', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        // Get rich details (story, features, specifications, included, colors)
        $details = ProductCatalogService::getDetails($product);

        // Fetch real reviews
        $reviews = $product->reviews()->where('is_approved', true)->with('user')->latest()->get();
        $reviewCount = $reviews->count();
        $avgRating = $reviewCount > 0 ? round($reviews->avg('rating'), 1) : 4.8;

        // Star breakdown
        $starBreakdown = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach ($reviews as $rev) {
            $r = (int)$rev->rating;
            if (isset($starBreakdown[$r])) {
                $starBreakdown[$r]++;
            }
        }

        return view('pages.product-detail', compact(
            'product',
            'relatedProducts',
            'details',
            'reviews',
            'reviewCount',
            'avgRating',
            'starBreakdown'
        ));
    }
}
