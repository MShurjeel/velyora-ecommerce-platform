<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class StoreRoutesTest extends TestCase
{
    public function test_public_pages_load_successfully(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/products')->assertStatus(200);
        $this->get('/product/1')->assertStatus(200);
        $this->get('/contact')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
        $this->get('/cart')->assertStatus(200);
        $this->get('/wishlist')->assertStatus(200);
    }

    public function test_catalog_filtering_and_sorting(): void
    {
        $this->get('/products?sort=newest')->assertStatus(200);
        $this->get('/products?sort=price-low')->assertStatus(200);
        $this->get('/products?max_price=5000')->assertStatus(200);
        $this->get('/products?filter=sale')->assertStatus(200);
        $this->get('/products?in_stock=1')->assertStatus(200);
    }

    public function test_contact_form_submission(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Sara Ahmed',
            'email' => 'sara@example.com',
            'phone' => '+92 300 1234567',
            'subject' => 'Inquiry about order delivery',
            'message' => 'Hello, I would like to know if you offer same-day delivery in Lahore.',
        ]);

        $response->assertRedirect('/contact');
        $response->assertSessionHas('success');
    }

    public function test_protected_routes_require_authentication(): void
    {
        $this->get('/my-profile')->assertRedirect('/login');
        $this->get('/my-orders')->assertRedirect('/login');
        $this->get('/checkout')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_profile(): void
    {
        $user = User::first() ?? User::factory()->create();

        $this->actingAs($user)
            ->get('/my-profile')
            ->assertStatus(200)
            ->assertSee($user->name);
    }

    public function test_guest_can_access_standalone_wishlist(): void
    {
        $response = $this->get('/wishlist');
        $response->assertStatus(200);
        $response->assertSee('Saved Items');
    }
}
