<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'id' => 1,
                'category_id' => 1,
                'name' => 'Premium Wireless Headphones',
                'description' => 'Immersive acoustic fidelity designed for everyday listening. Featuring custom 40mm dynamic drivers and hybrid active noise cancellation.',
                'story_heading' => 'Immersive acoustic fidelity designed for everyday listening.',
                'story_p1' => 'The Premium Wireless Headphones combine custom-tuned 40mm dynamic drivers, seamless multi-point wireless connectivity, and an understated Velyora ergonomic silhouette designed to fit naturally into everyday life.',
                'story_p2' => 'Whether you are working from a busy cafe, travelling on long flights, or simply enjoying your favourite playlist, the balanced sound profile and breathable memory-foam cushions are crafted to keep you listening longer.',
                'price' => 8499.00,
                'sale_price' => null,
                'stock_qty' => 35,
                'image' => 'assets/images/products/P1-img1.png',
                'is_featured' => 1,
                'status' => 'active',
                'gallery' => [
                    'assets/images/products/P1-img1.png',
                    'assets/images/products/P1-img2.png',
                    'assets/images/products/P1-img3.png',
                    'assets/images/products/P1-img4.png',
                ],
            ],
            [
                'id' => 2,
                'category_id' => 2,
                'name' => 'Premium Everyday Hoodie',
                'description' => 'Unmatched comfort, tailored for elevated everyday style. Crafted from heavyweight 420 GSM brushed organic cotton fleece.',
                'story_heading' => 'Unmatched comfort, tailored for elevated everyday style.',
                'story_p1' => 'The Premium Everyday Hoodie is crafted from heavyweight 420 GSM brushed organic cotton, striking the ideal balance between structured drape and cloud-like warmth.',
                'story_p2' => 'Designed with a modern relaxed silhouette, reinforced double-needle stitching, and a double-layered hood, it transitions effortlessly from chilled downtime to a polished streetwear aesthetic.',
                'price' => 4299.00,
                'sale_price' => 3699.00,
                'stock_qty' => 50,
                'image' => 'assets/images/products/P2-img1.png',
                'is_featured' => 1,
                'status' => 'active',
                'gallery' => [
                    'assets/images/products/P2-img1.png',
                    'assets/images/products/P2-img2.png',
                    'assets/images/products/P2-img3.png',
                    'assets/images/products/P2-img4.jpeg',
                ],
            ],
            [
                'id' => 3,
                'category_id' => 5,
                'name' => 'Urban Everyday Backpack',
                'description' => 'Engineered for the daily commute and weekend escapes. 1000D Cordura ballistic nylon with suspended 16-inch laptop chamber.',
                'story_heading' => 'Engineered for the daily commute and weekend escapes.',
                'story_p1' => 'Constructed from weatherproof 1000D Cordura nylon, the Urban Everyday Backpack delivers intelligent compartmentalization without the excess bulk of traditional bags.',
                'story_p2' => 'Featuring a dedicated padded 16-inch laptop chamber, quick-access transit pockets, and ergonomic airflow shoulder straps, it carries all your daily essentials safely and comfortably.',
                'price' => 6199.00,
                'sale_price' => 5499.00,
                'stock_qty' => 20,
                'image' => 'assets/images/products/P3-img1.png',
                'is_featured' => 1,
                'status' => 'active',
                'gallery' => [
                    'assets/images/products/P3-img1.png',
                    'assets/images/products/P3-img2.png',
                    'assets/images/products/P3-img3.png',
                    'assets/images/products/P3-img4.png',
                ],
            ],
            [
                'id' => 4,
                'category_id' => 4,
                'name' => 'Modern Lifestyle Essential',
                'description' => 'Refined minimalism crafted for your contemporary space. Architectural ceramic with satin matte finish.',
                'story_heading' => 'Refined minimalism crafted for your contemporary space.',
                'story_p1' => 'The Modern Lifestyle Essential brings intentional simplicity into your living or working environment, utilizing timeless geometric shapes and sustainable matte materials.',
                'story_p2' => 'Built with meticulous attention to tactile quality and subtle textures, it effortlessly complements contemporary interior styles while serving a practical everyday purpose.',
                'price' => 3499.00,
                'sale_price' => null,
                'stock_qty' => 15,
                'image' => 'assets/images/products/product-f-1.webp',
                'is_featured' => 1,
                'status' => 'active',
                'gallery' => [
                    'assets/images/products/product-f-1.webp',
                ],
            ],
            [
                'id' => 5,
                'category_id' => 5,
                'name' => 'Everyday Essentials RFID Wallet',
                'description' => 'Carefully curated essentials to streamline your everyday carry. Anodized 6061-T6 aluminum with RFID shielding.',
                'story_heading' => 'Carefully curated essentials to streamline your everyday carry.',
                'story_p1' => 'The Everyday Essentials pack delivers refined functional carry items engineered for daily organization, combining durable anodized alloy hardware with supple textured finishes.',
                'story_p2' => 'Each element is tailored to streamline your pocket carry, reducing bulk and adding a touch of understated elegance to your daily routine.',
                'price' => 2199.00,
                'sale_price' => 1899.00,
                'stock_qty' => 40,
                'image' => 'assets/images/products/P5-img1.png',
                'is_featured' => 0,
                'status' => 'active',
                'gallery' => [
                    'assets/images/products/P5-img1.png',
                    'assets/images/products/P5-img2.png',
                    'assets/images/products/P5-img3.png',
                    'assets/images/products/P5-img4.png',
                ],
            ],
            [
                'id' => 6,
                'category_id' => 2,
                'name' => 'Modern Street Style Joggers',
                'description' => 'Bold contours and contemporary urban silhouette. Durable performance ripstop cotton blend.',
                'story_heading' => 'Bold contours and contemporary urban silhouette.',
                'story_p1' => 'The Modern Street Style collection embodies the energy of modern city life with relaxed tailoring, durable performance fabric, and sharp architectural paneling.',
                'story_p2' => 'Built for movement and versatile layering, it pairs effortlessly with minimal sneakers and technical outer layers for an elevated, clean urban look.',
                'price' => 3899.00,
                'sale_price' => 3299.00,
                'stock_qty' => 30,
                'image' => 'assets/images/products/P6-img1.png',
                'is_featured' => 0,
                'status' => 'active',
                'gallery' => [
                    'assets/images/products/P6-img1.png',
                    'assets/images/products/P6-img2.png',
                    'assets/images/products/P6-img3.png',
                    'assets/images/products/P6-img4.jpeg',
                ],
            ],
            [
                'id' => 7,
                'category_id' => 1,
                'name' => 'Smart Tech 100W USB-C Hub',
                'description' => 'Intelligent performance designed for seamless connectivity. Unibody CNC aluminum enclosure with 4K HDMI and 100W PD.',
                'story_heading' => 'Intelligent performance designed for seamless connectivity.',
                'story_p1' => 'The Smart Tech Essential integrates advanced processing power with ultra-low latency wireless protocols to keep your digital workflow fluid and responsive throughout the day.',
                'story_p2' => 'Housed in a precision CNC-machined aluminum alloy chassis, it combines industrial durability with an elegant, compact desktop footprint.',
                'price' => 5299.00,
                'sale_price' => 4699.00,
                'stock_qty' => 25,
                'image' => 'assets/images/products/P7-img1.png',
                'is_featured' => 0,
                'status' => 'active',
                'gallery' => [
                    'assets/images/products/P7-img1.png',
                    'assets/images/products/P7-img2.png',
                    'assets/images/products/P7-img3.png',
                    'assets/images/products/P7-img-4.png',
                ],
            ],
            [
                'id' => 8,
                'category_id' => 4,
                'name' => 'Contemporary Home Wall Shelf',
                'description' => 'Transform your living space with purposeful warmth. Solid European oak and architectural ceramic.',
                'story_heading' => 'Transform your living space with purposeful warmth.',
                'story_p1' => 'Crafted to elevate modern interiors, the Contemporary Home Essential combines warm organic undertones with clean structural lines to create a calming focal point in any room.',
                'story_p2' => 'Hand-finished with sustainable, non-toxic materials, it is built to withstand everyday domestic use while maintaining its pristine aesthetic appeal year after year.',
                'price' => 4199.00,
                'sale_price' => null,
                'stock_qty' => 18,
                'image' => 'assets/images/products/product-f-2.webp',
                'is_featured' => 0,
                'status' => 'active',
                'gallery' => [
                    'assets/images/products/product-f-2.webp',
                ],
            ],
            [
                'id' => 9,
                'category_id' => 1,
                'name' => 'Midnight Titanium Smartwatch',
                'description' => 'Precision health analytics encased in aerospace titanium. AMOLED Sapphire display with 14-day battery life.',
                'story_heading' => 'Precision health analytics encased in aerospace titanium.',
                'story_p1' => 'Forged from grade-5 aerospace titanium with a scratch-resistant sapphire crystal AMOLED display, the Midnight Titanium Smartwatch is built for both boardroom elegance and rugged outdoor exploration.',
                'story_p2' => 'With comprehensive 24/7 biometric tracking, multi-band GPS navigation, and up to 14 days of battery life, it keeps you informed and connected wherever your day takes you.',
                'price' => 12999.00,
                'sale_price' => 10999.00,
                'stock_qty' => 20,
                'image' => 'assets/images/products/P9-img1.png',
                'is_featured' => 1,
                'status' => 'active',
                'gallery' => [
                    'assets/images/products/P9-img1.png',
                    'assets/images/products/P9-img2.png',
                    'assets/images/products/P9-img-3.png',
                    'assets/images/products/P9-img4.png',
                ],
            ],
        ];

        foreach ($products as $item) {
            $gallery = $item['gallery'] ?? [];
            unset($item['gallery']);

            $product = Product::updateOrCreate(['id' => $item['id']], $item);

            // Add gallery images
            foreach ($gallery as $index => $imgPath) {
                ProductImage::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'image_path' => $imgPath,
                    ],
                    [
                        'is_primary' => ($index === 0) ? 1 : 0,
                        'sort_order' => $index + 1,
                    ]
                );
            }
        }
    }
}

