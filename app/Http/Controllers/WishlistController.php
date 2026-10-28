<?php

namespace App\Http\Controllers;

use App\Services\WishlistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect(route('profile') . '#v-pills-wishlist');
        }

        $wishlistItems = WishlistService::getWishlistItems();
        return view('pages.wishlist', compact('wishlistItems'));
    }

    public function handleAjax(Request $request)
    {
        $action = $request->input('action', 'toggle');

        switch ($action) {
            case 'toggle':
                $productId = (int) $request->input('product_id');
                $res = WishlistService::toggle($productId);
                return response()->json($res);

            case 'remove':
                $productId = (int) $request->input('product_id');
                $res = WishlistService::remove($productId);
                return response()->json($res);

            case 'add_all_to_cart':
                $res = WishlistService::addAllToCart();
                return response()->json($res);

            default:
                return response()->json(['success' => false, 'message' => 'Unknown action.']);
        }
    }
}

