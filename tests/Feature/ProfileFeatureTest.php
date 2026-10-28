<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class ProfileFeatureTest extends TestCase
{
    public function test_user_can_manage_addresses(): void
    {
        $user = User::where('email', 'shurjeel@example.com')->first() ?? User::factory()->create();

        // 1. Create Address
        $res = $this->actingAs($user)->post('/my-profile/addresses', [
            'title' => 'Feature Test Office',
            'recipient_name' => 'Shurjeel Test',
            'phone' => '+92 300 1112233',
            'address_line1' => 'Gulberg III, Main Blvd',
            'city' => 'Lahore',
            'country' => 'Pakistan',
            'is_default' => 1,
        ]);
        $res->assertRedirect('/my-profile#v-pills-addresses');

        $this->assertDatabaseHas('user_addresses', [
            'title' => 'Feature Test Office',
            'user_id' => $user->id,
        ]);

        $addr = $user->addresses()->where('title', 'Feature Test Office')->first();

        // 2. Update Address
        $resUpdate = $this->actingAs($user)->put('/my-profile/addresses/' . $addr->id, [
            'title' => 'Feature Test Office Edited',
            'recipient_name' => 'Shurjeel Test',
            'phone' => '+92 300 1112233',
            'address_line1' => 'Gulberg III, Main Blvd 2nd Floor',
            'city' => 'Lahore',
            'country' => 'Pakistan',
        ]);
        $resUpdate->assertRedirect('/my-profile#v-pills-addresses');

        $this->assertDatabaseHas('user_addresses', [
            'id' => $addr->id,
            'title' => 'Feature Test Office Edited',
        ]);

        // 3. Delete Address
        $resDelete = $this->actingAs($user)->delete('/my-profile/addresses/' . $addr->id);
        $resDelete->assertRedirect('/my-profile#v-pills-addresses');

        $this->assertDatabaseMissing('user_addresses', [
            'id' => $addr->id,
        ]);
    }

    public function test_user_can_manage_payment_methods(): void
    {
        $user = User::where('email', 'shurjeel@example.com')->first() ?? User::factory()->create();

        // 1. Add Card
        $res = $this->actingAs($user)->post('/my-profile/payment-methods', [
            'cardholder_name' => 'M Shurjeel',
            'card_number' => '5555 4444 3333 1212',
            'expiry_month' => '07',
            'expiry_year' => '2028',
            'is_default' => 0,
        ]);
        $res->assertRedirect('/my-profile#v-pills-payments');

        $this->assertDatabaseHas('user_payment_methods', [
            'card_last_four' => '1212',
            'user_id' => $user->id,
        ]);

        $card = $user->paymentMethods()->where('card_last_four', '1212')->first();

        // 2. Set Default
        $resDefault = $this->actingAs($user)->post('/my-profile/payment-methods/' . $card->id . '/default');
        $resDefault->assertRedirect('/my-profile#v-pills-payments');

        $card->refresh();
        $this->assertTrue((bool)$card->is_default);

        // 3. Delete Card
        $resDel = $this->actingAs($user)->delete('/my-profile/payment-methods/' . $card->id);
        $resDel->assertRedirect('/my-profile#v-pills-payments');

        $this->assertDatabaseMissing('user_payment_methods', [
            'id' => $card->id,
        ]);
    }

    public function test_user_can_manage_reviews(): void
    {
        $user = User::where('email', 'shurjeel@example.com')->first() ?? User::factory()->create();
        $prod = Product::first();

        // 1. Add Review
        $res = $this->actingAs($user)->post('/my-profile/reviews', [
            'product_id' => $prod->id,
            'rating' => 4,
            'comment' => 'Automated test review - super comfortable and well made!',
        ]);
        $res->assertRedirect('/my-profile#v-pills-reviews');

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'product_id' => $prod->id,
            'rating' => 4,
        ]);

        $rev = $user->reviews()->where('comment', 'Automated test review - super comfortable and well made!')->first();

        // 2. Delete Review
        $resDel = $this->actingAs($user)->delete('/my-profile/reviews/' . $rev->id);
        $resDel->assertRedirect('/my-profile#v-pills-reviews');

        $this->assertDatabaseMissing('reviews', [
            'id' => $rev->id,
        ]);
    }

    public function test_user_can_update_profile_settings(): void
    {
        $user = User::where('email', 'shurjeel@example.com')->first() ?? User::factory()->create();

        $res = $this->actingAs($user)->put('/my-profile/settings', [
            'name' => 'M Shurjeel Rajpoot Updated',
            'email' => 'shurjeel@example.com',
            'phone' => '+92 300 7776655',
            'country' => 'Pakistan',
            'order_updates' => 1,
            'promotions' => 1,
        ]);
        $res->assertRedirect('/my-profile#v-pills-settings');

        $user->refresh();
        $this->assertEquals('M Shurjeel Rajpoot Updated', $user->name);
        $this->assertEquals('+92 300 7776655', $user->phone);

        // Revert name back to clean
        $user->update(['name' => 'M Shurjeel Rajpoot']);
    }
}

