<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\UserAddress;
use App\Models\UserPaymentMethod;
use App\Services\WishlistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Status badge config matching legacy styling
        $statusConfig = [
            'Pending'    => ['bg' => '#F3F4F6', 'color' => '#6B7280', 'icon' => 'bi-hourglass-split'],
            'Processing' => ['bg' => '#FEF3C7', 'color' => '#D97706', 'icon' => 'bi-clock-history'],
            'Shipped'    => ['bg' => '#DBEAFE', 'color' => '#2563EB', 'icon' => 'bi-truck'],
            'Delivered'  => ['bg' => '#DCFCE7', 'color' => '#16A34A', 'icon' => 'bi-check-circle'],
            'Cancelled'  => ['bg' => '#FEE2E2', 'color' => '#DC2626', 'icon' => 'bi-x-circle'],
            'Refunded'   => ['bg' => '#F3E8FF', 'color' => '#7C3AED', 'icon' => 'bi-arrow-counterclockwise'],
            'On Hold'    => ['bg' => '#FEF3C7', 'color' => '#92400E', 'icon' => 'bi-pause-circle'],
        ];
        $defaultStatus = ['bg' => '#F1F5F9', 'color' => '#475569', 'icon' => 'bi-info-circle'];

        $userOrders = Order::with(['items.product.images'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $wishlistItems = WishlistService::getWishlistItems();
        $addresses = $user->addresses()->get();
        $paymentMethods = $user->paymentMethods()->get();
        $reviews = $user->reviews()->get();
        $products = Product::orderBy('name')->get();

        return view('pages.profile', compact(
            'user',
            'userOrders',
            'wishlistItems',
            'statusConfig',
            'defaultStatus',
            'addresses',
            'paymentMethods',
            'reviews',
            'products'
        ));
    }

    public function orders()
    {
        return redirect(route('profile') . '#v-pills-orders');
    }

    // --- Addresses ---
    public function storeAddress(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
            'is_default' => ['nullable'],
        ]);

        $isDefault = $request->boolean('is_default') || $user->addresses()->count() === 0;

        if ($isDefault) {
            $user->addresses()->update(['is_default' => false]);
        }

        $validated['user_id'] = $user->id;
        $validated['is_default'] = $isDefault;

        UserAddress::create($validated);

        return redirect(route('profile') . '#v-pills-addresses')->with('success', 'Address added successfully!');
    }

    public function updateAddress(Request $request, $id)
    {
        $user = Auth::user();
        $address = $user->addresses()->findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
            'is_default' => ['nullable'],
        ]);

        $isDefault = $request->boolean('is_default');

        if ($isDefault) {
            $user->addresses()->where('id', '!=', $id)->update(['is_default' => false]);
            $validated['is_default'] = true;
        } else {
            // Keep default if it was default and no other default exists
            if ($address->is_default && $user->addresses()->where('id', '!=', $id)->where('is_default', true)->doesntExist()) {
                $validated['is_default'] = true;
            } else {
                $validated['is_default'] = false;
            }
        }

        $address->update($validated);

        return redirect(route('profile') . '#v-pills-addresses')->with('success', 'Address updated successfully!');
    }

    public function destroyAddress($id)
    {
        $user = Auth::user();
        $address = $user->addresses()->findOrFail($id);
        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            $first = $user->addresses()->first();
            if ($first) {
                $first->update(['is_default' => true]);
            }
        }

        return redirect(route('profile') . '#v-pills-addresses')->with('success', 'Address removed successfully.');
    }

    public function setDefaultAddress($id)
    {
        $user = Auth::user();
        $user->addresses()->update(['is_default' => false]);
        $user->addresses()->where('id', $id)->update(['is_default' => true]);

        return redirect(route('profile') . '#v-pills-addresses')->with('success', 'Default address updated!');
    }

    // --- Payment Methods ---
    public function storePaymentMethod(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'cardholder_name' => ['required', 'string', 'max:255'],
            'card_number' => ['required', 'string', 'min:12', 'max:25'],
            'expiry_month' => ['required', 'string', 'min:1', 'max:2'],
            'expiry_year' => ['required', 'string', 'min:2', 'max:4'],
            'card_type' => ['nullable', 'string'],
            'is_default' => ['nullable'],
        ]);

        $cleanNumber = preg_replace('/\D/', '', $validated['card_number']);
        $lastFour = substr($cleanNumber, -4) ?: '0000';

        $cardType = $request->input('card_type');
        if (!$cardType) {
            $cardType = str_starts_with($cleanNumber, '4') ? 'Visa' : (str_starts_with($cleanNumber, '5') ? 'Mastercard' : 'Card');
        }

        $isDefault = $request->boolean('is_default') || $user->paymentMethods()->count() === 0;

        if ($isDefault) {
            $user->paymentMethods()->update(['is_default' => false]);
        }

        $user->paymentMethods()->create([
            'card_type' => $cardType,
            'cardholder_name' => $validated['cardholder_name'],
            'card_last_four' => $lastFour,
            'expiry_month' => str_pad($validated['expiry_month'], 2, '0', STR_PAD_LEFT),
            'expiry_year' => strlen($validated['expiry_year']) === 2 ? ('20' . $validated['expiry_year']) : $validated['expiry_year'],
            'is_default' => $isDefault,
        ]);

        return redirect(route('profile') . '#v-pills-payments')->with('success', 'Payment card added successfully!');
    }

    public function destroyPaymentMethod($id)
    {
        $user = Auth::user();
        $card = $user->paymentMethods()->findOrFail($id);
        $wasDefault = $card->is_default;
        $card->delete();

        if ($wasDefault) {
            $first = $user->paymentMethods()->first();
            if ($first) {
                $first->update(['is_default' => true]);
            }
        }

        return redirect(route('profile') . '#v-pills-payments')->with('success', 'Payment card removed.');
    }

    public function setDefaultPaymentMethod($id)
    {
        $user = Auth::user();
        $user->paymentMethods()->update(['is_default' => false]);
        $user->paymentMethods()->where('id', $id)->update(['is_default' => true]);

        return redirect(route('profile') . '#v-pills-payments')->with('success', 'Default payment method updated!');
    }

    // --- Reviews ---
    public function storeReview(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        $validated['user_id'] = $user->id;
        $validated['is_approved'] = true;

        Review::create($validated);

        return redirect(route('profile') . '#v-pills-reviews')->with('success', 'Your review has been published!');
    }

    public function destroyReview($id)
    {
        $user = Auth::user();
        $review = $user->reviews()->findOrFail($id);
        $review->delete();

        return redirect(route('profile') . '#v-pills-reviews')->with('success', 'Review deleted successfully.');
    }

    // --- Account Settings ---
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:100'],
            'promotions' => ['nullable'],
            'order_updates' => ['nullable'],
        ]);

        $validated['promotions'] = $request->has('promotions');
        $validated['order_updates'] = $request->has('order_updates');

        $user->update($validated);

        return redirect(route('profile') . '#v-pills-settings')->with('success', 'Personal information and email preferences saved!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect(route('profile') . '#v-pills-settings')->with('success', 'Password updated successfully!');
    }

    public function destroyAccount(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('info', 'Your account has been deleted.');
    }
}
