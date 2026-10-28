<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminRoutesTest extends TestCase
{
    use DatabaseTransactions;
    public function test_admin_dashboard_loads(): void
    {
        $response = $this->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Total Revenue');
        $response->assertSee('Active Products');
    }

    public function test_admin_categories_index_and_create(): void
    {
        $response = $this->get('/admin/categories');
        $response->assertStatus(200);
        $response->assertSee('Categories Management');

        $testCategoryName = 'Test Cat ' . uniqid();
        $createResponse = $this->post('/admin/categories', [
            'name' => $testCategoryName,
            'slug' => 'test-cat-' . uniqid(),
            'icon' => 'bi-tag',
            'status' => 'active',
        ]);

        $createResponse->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', ['name' => $testCategoryName]);
    }

    public function test_admin_products_index_and_create_page(): void
    {
        $response = $this->get('/admin/products');
        $response->assertStatus(200);
        $response->assertSee('Products Management');

        $createPageResponse = $this->get('/admin/products/create');
        $createPageResponse->assertStatus(200);
        $createPageResponse->assertSee('Add New Product');
    }

    public function test_admin_can_create_and_update_product(): void
    {
        $category = Category::first() ?? Category::create(['name' => 'General', 'slug' => 'general']);

        $productName = 'Admin Test Product ' . uniqid();
        $createResponse = $this->post('/admin/products', [
            'name' => $productName,
            'slug' => 'admin-test-product-' . uniqid(),
            'category_id' => $category->id,
            'price' => 4500,
            'sale_price' => 3999,
            'stock_qty' => 25,
            'status' => 'active',
            'is_featured' => 1,
            'description' => 'Test product description for admin panel test.',
        ]);

        $createResponse->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => $productName]);

        $product = Product::where('name', $productName)->first();

        // Test editing product
        $updateResponse = $this->put(route('admin.products.update', $product->id), [
            'name' => $productName . ' Updated',
            'slug' => $product->slug . '-updated',
            'category_id' => $category->id,
            'price' => 5000,
            'sale_price' => 4500,
            'stock_qty' => 30,
            'status' => 'active',
            'is_featured' => 0,
            'description' => 'Updated description.',
        ]);

        $updateResponse->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => $productName . ' Updated']);
    }

    public function test_admin_orders_index_and_status_update(): void
    {
        $order = Order::create([
            'order_number' => 'VEL-TEST-' . rand(1000, 9999),
            'customer_name' => 'Jane Tester',
            'email' => 'jane@example.com',
            'phone' => '03001234567',
            'address' => 'Street 5, Test Town',
            'city' => 'Karachi',
            'subtotal' => 2500,
            'shipping' => 150,
            'tax' => 50,
            'total_amount' => 2700,
            'payment_method' => 'Cash on Delivery',
            'payment_status' => 'Pending',
            'order_status' => 'Processing',
        ]);

        $response = $this->get('/admin/orders');
        $response->assertStatus(200);
        $response->assertSee('Orders');
        $response->assertSee('Shipments');
        $response->assertSee($order->order_number);

        // Update status to Shipped
        $statusUpdate = $this->put(route('admin.orders.updateStatus', $order->id), [
            'order_status' => 'Shipped',
        ]);

        $statusUpdate->assertStatus(302);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_status' => 'Shipped',
        ]);
    }
}

