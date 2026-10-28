<?php

namespace App\Services;

use App\Models\Product;

class ProductCatalogService
{
    public static function getDetails(Product $product): array
    {
        $id = $product->id;
        $name = $product->name;
        $category = $product->category ? $product->category->name : 'General';
        $desc = $product->description ?? '';

        $catalog = [
            1 => [
                'story_heading' => 'Immersive acoustic fidelity designed for everyday listening.',
                'story_p1' => 'The Premium Wireless Headphones combine custom-tuned 40mm dynamic drivers, seamless multi-point wireless connectivity, and an understated Velyora ergonomic silhouette designed to fit naturally into everyday life.',
                'story_p2' => 'Whether you are working from a busy cafe, travelling on long flights, or simply enjoying your favourite playlist, the balanced sound profile and breathable memory-foam cushions are crafted to keep you listening longer.',
                'features' => [
                    ['icon' => 'bi-soundwave', 'title' => 'Active Noise Cancellation', 'text' => 'Hybrid ANC technology eliminates up to 35dB of low-frequency ambient noise.'],
                    ['icon' => 'bi-battery-charging', 'title' => '40-Hour Battery Life', 'text' => 'Fast USB-C charging delivers up to 4 hours of playtime with a quick 10-minute charge.'],
                    ['icon' => 'bi-music-note-beamed', 'title' => 'Custom 40mm Drivers', 'text' => 'Precision-engineered dynamic diaphragms deliver deep bass and sparkling acoustic clarity.'],
                    ['icon' => 'bi-feather', 'title' => 'Featherlight Ergonomics', 'text' => 'Ultra-soft memory foam earcups wrapped in breathable protein leather for all-day comfort.']
                ],
                'included' => [
                    $name,
                    'Braided USB-C Fast-Charging Cable',
                    '3.5mm Gold-Plated Audio Auxiliary Cable',
                    'Hardshell Travel Storage Case',
                    'Quick Start Guide & Warranty Card'
                ],
                'specifications' => [
                    'Audio Performance' => [
                        'Driver Unit' => '40mm Neodymium Dynamic Diaphragm',
                        'Frequency Response' => '20 Hz - 40,000 Hz',
                        'Active Noise Cancellation' => 'Hybrid Digital ANC (up to 35 dB)',
                        'Impedance' => '32 Ohms'
                    ],
                    'Wireless & Connectivity' => [
                        'Bluetooth Version' => 'Bluetooth 5.3 Multipoint',
                        'Audio Codecs' => 'AAC, SBC, LDAC Hi-Res Audio',
                        'Operating Range' => 'Up to 15 meters (50 feet)'
                    ],
                    'Battery & Power' => [
                        'Playtime' => 'Up to 40 hours (ANC Off) / 30 hours (ANC On)',
                        'Charging Port' => 'USB Type-C',
                        'Recharge Time' => '90 minutes to full charge'
                    ],
                    'Build & Dimensions' => [
                        'Weight' => '250 grams',
                        'Headband Material' => 'Brushed Anodized Aluminum Alloy',
                        'Ear Cushion' => 'High-Density Breathable Memory Foam'
                    ]
                ],
                'colors' => [
                    ['name' => 'Midnight', 'value' => '#0A1020'],
                    ['name' => 'Matte Silver', 'value' => '#C0C4C8'],
                    ['name' => 'Sandstone', 'value' => '#D9CDB8']
                ]
            ],
            2 => [
                'story_heading' => 'Unmatched comfort, tailored for elevated everyday style.',
                'story_p1' => 'The Premium Everyday Hoodie is crafted from heavyweight 420 GSM brushed organic cotton, striking the ideal balance between structured drape and cloud-like warmth.',
                'story_p2' => 'Designed with a modern relaxed silhouette, reinforced double-needle stitching, and a double-layered hood, it transitions effortlessly from chilled downtime to a polished streetwear aesthetic.',
                'features' => [
                    ['icon' => 'bi-feather', 'title' => '420 GSM Heavyweight Cotton', 'text' => 'Dense brushed loopback cotton fleece providing superior warmth and drape.'],
                    ['icon' => 'bi-scissors', 'title' => 'Modern Relaxed Fit', 'text' => 'Dropped shoulder styling tailored for effortless daily layering and streetwear appeal.'],
                    ['icon' => 'bi-shield-check', 'title' => 'Reinforced Construction', 'text' => 'Durable double-needle flatlock seams engineered to endure years of everyday wear.'],
                    ['icon' => 'bi-check2-circle', 'title' => 'Double-Layered Hood', 'text' => 'Structured, self-lined hood that holds its shape, complete with custom matte metal eyelets.']
                ],
                'included' => [
                    $name,
                    'Velyora Breathable Cotton Dust Bag',
                    'Fabric Care & Maintenance Guide'
                ],
                'specifications' => [
                    'Fabric & Material' => [
                        'Material' => '100% GOTS Certified Organic Cotton',
                        'Fabric Weight' => '420 GSM Heavyweight Fleece',
                        'Interior Finish' => 'Brushed French Terry',
                        'Pre-Shrunk' => 'Yes (Garment Washed)'
                    ],
                    'Design & Details' => [
                        'Cut & Silhouette' => 'Modern Relaxed / Drop-Shoulder',
                        'Hood' => 'Double-Layered Structured Hood',
                        'Pocket' => 'Kangaroo Front Pouch with Bar-Tack Stitching',
                        'Ribbing' => 'Heavyweight 2x2 Elasticated Cotton Rib Hem & Cuffs'
                    ],
                    'Care Instructions' => [
                        'Washing' => 'Machine wash cold with like colors inside out',
                        'Drying' => 'Line dry recommended; tumble dry low if needed',
                        'Ironing' => 'Cool iron on reverse side'
                    ]
                ],
                'colors' => [
                    ['name' => 'Carbon Black', 'value' => '#1E1E20'],
                    ['name' => 'Heather Grey', 'value' => '#8C8F95'],
                    ['name' => 'Forest Green', 'value' => '#2D3B32']
                ]
            ],
            3 => [
                'story_heading' => 'Engineered for the daily commute and weekend escapes.',
                'story_p1' => 'Constructed from weatherproof 1000D Cordura nylon, the Urban Everyday Backpack delivers intelligent compartmentalization without the excess bulk of traditional bags.',
                'story_p2' => 'Featuring a dedicated padded 16-inch laptop chamber, quick-access transit pockets, and ergonomic airflow shoulder straps, it carries all your daily essentials safely and comfortably.',
                'features' => [
                    ['icon' => 'bi-droplet', 'title' => 'Weatherproof Cordura', 'text' => '1000D ballistic nylon shell paired with YKK AquaGuard water-repellent zippers.'],
                    ['icon' => 'bi-laptop', 'title' => '16" Suspended Laptop Sleeve', 'text' => 'False-bottom padded chamber protects your laptop from accidental drops and impacts.'],
                    ['icon' => 'bi-grid-3x3-gap', 'title' => 'Smart Tech Organization', 'text' => 'Dedicated dividers and quick-access pockets for cables, chargers, keys, and water bottle.'],
                    ['icon' => 'bi-person-walking', 'title' => 'Ergonomic Airflow Harness', 'text' => 'Breathable dual-density foam shoulder straps and contoured ventilated back panel.']
                ],
                'included' => [
                    $name,
                    'Removable Quick-Release Key Leash',
                    'Integrated Weatherproof Rain Shield Cover',
                    'Luggage Pass-Through Strap'
                ],
                'specifications' => [
                    'Dimensions & Capacity' => [
                        'Volume Capacity' => '24 Liters',
                        'Dimensions' => '48 cm x 31 cm x 16 cm (19" x 12.2" x 6.3")',
                        'Weight' => '980 grams (empty)'
                    ],
                    'Materials & Hardware' => [
                        'Shell Fabric' => '1000D Weather-Resistant Cordura Ballistic Nylon',
                        'Lining' => '210D Ripstop Honeycomb Polyester',
                        'Zippers' => 'Genuine YKK AquaGuard Weather-Sealed Zips',
                        'Hardware' => 'Duraflex High-Strength Acetal Buckles'
                    ],
                    'Compartment Layout' => [
                        'Laptop Chamber' => 'Dedicated false-bottom sleeve for up to 16" MacBook Pro',
                        'Tablet Slot' => 'Padded compartment for up to 11" iPad',
                        'Exterior Storage' => '2 Front quick-access stash pockets, hidden passport pocket',
                        'Side Sleeve' => 'Expandable water bottle pocket with magnetic closure'
                    ]
                ],
                'colors' => [
                    ['name' => 'Obsidian Black', 'value' => '#1B1C1E'],
                    ['name' => 'Slate Grey', 'value' => '#4A4D52'],
                    ['name' => 'Olive Drab', 'value' => '#3E4435']
                ]
            ],
            5 => [
                'story_heading' => 'Carefully curated essentials to streamline your everyday carry.',
                'story_p1' => 'The Everyday Essentials pack delivers refined functional carry items engineered for daily organization, combining durable anodized alloy hardware with supple textured finishes.',
                'story_p2' => 'Each element is tailored to streamline your pocket carry, reducing bulk and adding a touch of understated elegance to your daily routine.',
                'features' => [
                    ['icon' => 'bi-box', 'title' => 'Streamlined Footprint', 'text' => 'Engineered to reduce pocket bulk while maximizing everyday accessibility and order.'],
                    ['icon' => 'bi-shield-lock', 'title' => 'Anodized Aircraft Alloy', 'text' => 'Lightweight 6061-T6 aluminum construction with bead-blasted satin matte protection.'],
                    ['icon' => 'bi-lightning-charge', 'title' => 'Instant Quick Access', 'text' => 'Ergonomic quick-draw mechanics allow one-handed access to your most-used items.'],
                    ['icon' => 'bi-brush', 'title' => 'Minimalist Finish', 'text' => 'Precision beveled edges and understated laser branding for refined daily carry.']
                ],
                'included' => [
                    $name,
                    'Custom Protective Carry Sleeve',
                    'Mini Torx Adjustment Tool',
                    'Velyora Welcome Card & Warranty'
                ],
                'specifications' => [
                    'Hardware & Build' => [
                        'Chassis Material' => '6061-T6 Anodized Aircraft Aluminum',
                        'Fasteners' => 'Corrosion-Resistant Grade 304 Stainless Steel',
                        'Surface Finish' => 'Bead-Blasted Hard-Anodized Matte'
                    ],
                    'Dimensions & Capacity' => [
                        'Dimensions' => '10.5 cm x 6.2 cm x 1.4 cm',
                        'Weight' => '115 grams',
                        'Capacity' => 'Up to 12 cards plus folded bills'
                    ]
                ],
                'colors' => [
                    ['name' => 'Gunmetal', 'value' => '#2B2D31'],
                    ['name' => 'Brushed Silver', 'value' => '#D1D5DB'],
                    ['name' => 'Desert Tan', 'value' => '#C2A684']
                ]
            ],
            7 => [
                'story_heading' => 'Intelligent performance designed for seamless connectivity.',
                'story_p1' => 'The Smart Tech Essential integrates advanced processing power with ultra-low latency wireless protocols to keep your digital workflow fluid and responsive throughout the day.',
                'story_p2' => 'Housed in a precision CNC-machined aluminum alloy chassis, it combines industrial durability with an elegant, compact desktop footprint.',
                'features' => [
                    ['icon' => 'bi-cpu', 'title' => 'Intelligent Core Chipset', 'text' => 'Next-generation integrated controller optimized for fast, reliable data throughput.'],
                    ['icon' => 'bi-wifi', 'title' => 'Ultra-Low Latency Wireless', 'text' => 'High-bandwidth connectivity ensures stable connection across multiple devices.'],
                    ['icon' => 'bi-thermometer-half', 'title' => 'Passive Heat Dissipation', 'text' => 'Full CNC aluminum unibody acts as an efficient heat sink for whisper-quiet operation.'],
                    ['icon' => 'bi-usb-symbol', 'title' => 'Universal Compatibility', 'text' => 'Plug-and-play performance across macOS, Windows, Linux, iOS, and Android systems.']
                ],
                'included' => [
                    $name,
                    'Braided USB-C to USB-C Cable (1.5 meters)',
                    'USB-A to USB-C High-Speed Adapter',
                    'User Instruction Manual & Warranty Card'
                ],
                'specifications' => [
                    'Connectivity & Ports' => [
                        'Interface' => 'USB 3.2 Gen 2 Type-C (Up to 10 Gbps)',
                        'Power Delivery' => '100W USB-C PD Pass-Through Fast Charging',
                        'Video Output' => 'HDMI 2.0 (Up to 4K @ 60Hz HDR)',
                    ]
                ],
                'colors' => [
                    ['name' => 'Space Grey', 'value' => '#33373E'],
                    ['name' => 'Silver', 'value' => '#E2E5E9']
                ]
            ],
            9 => [
                'story_heading' => 'Precision health analytics encased in aerospace titanium.',
                'story_p1' => 'Forged from grade-5 aerospace titanium with a scratch-resistant sapphire crystal AMOLED display, the Midnight Titanium Smartwatch is built for both boardroom elegance and rugged outdoor exploration.',
                'story_p2' => 'With comprehensive 24/7 biometric tracking, multi-band GPS navigation, and up to 14 days of battery life, it keeps you informed and connected wherever your day takes you.',
                'features' => [
                    ['icon' => 'bi-shield-shaded', 'title' => 'Grade 5 Aerospace Titanium', 'text' => 'Ultra-strong titanium casing with diamond-like carbon (DLC) scratch resistance.'],
                    ['icon' => 'bi-smartwatch', 'title' => '1.43" AMOLED Sapphire Display', 'text' => 'Ultra-bright 2000-nit sunlight readable display protected by sapphire crystal.'],
                    ['icon' => 'bi-heart-pulse', 'title' => 'Advanced Biometric Suite', 'text' => 'Real-time ECG monitoring, SpO2 blood oxygen, HRV stress levels, and sleep analytics.'],
                    ['icon' => 'bi-battery-full', 'title' => '14-Day Battery & 50M Water Resistance', 'text' => 'Extended 14-day battery life with 5 ATM water resistance rating for swimming and rain.']
                ],
                'included' => [
                    $name,
                    'Magnetic Fast-Charging Dock with Braided Cable',
                    'Premium Fluoroelastomer Sport Strap',
                    'Aerospace Titanium Link Bracelet with Pin Tool',
                    'User Manual & Official 2-Year Warranty'
                ],
                'specifications' => [
                    'Display & Case' => [
                        'Case Material' => 'Grade 5 Aerospace Titanium Alloy with DLC Coating',
                        'Case Diameter' => '46 mm (11.8 mm thickness)',
                        'Display' => '1.43-inch Always-On AMOLED (466 x 466 px, 326 PPI)',
                    ]
                ],
                'colors' => [
                    ['name' => 'Titanium Black', 'value' => '#1A1C1E'],
                    ['name' => 'Raw Titanium', 'value' => '#878B91']
                ]
            ],
        ];

        // Generic fallback for other products
        $data = $catalog[$id] ?? [
            'story_heading' => $product->story_heading ?: 'Crafted for elevated modern living.',
            'story_p1' => $product->story_p1 ?: ($desc ?: "The {$name} represents Velyora's commitment to quality craftsmanship and understated modern aesthetics."),
            'story_p2' => $product->story_p2 ?: 'Engineered with precision materials and functional design, it seamlessly integrates into your daily life with enduring performance and style.',
            'features' => [
                ['icon' => 'bi-shield-check', 'title' => 'Velyora Quality Standard', 'text' => 'Built to endure with premium materials and strict quality control.'],
                ['icon' => 'bi-gem', 'title' => 'Considered Aesthetic', 'text' => 'Understated modern design tailored to fit naturally into everyday life.'],
                ['icon' => 'bi-patch-check', 'title' => 'Official Velyora Guarantee', 'text' => 'Comprehensive 1-year product warranty with dedicated customer support.']
            ],
            'included' => [
                $name,
                'Velyora Protective Packaging',
                'Product Care & User Guide',
                'Official Warranty Card'
            ],
            'specifications' => [
                'General Information' => [
                    'Product' => $name,
                    'Category' => $category,
                    'Brand' => 'Velyora',
                    'Warranty' => '1 Year Official Warranty'
                ]
            ],
            'colors' => [
                ['name' => 'Midnight', 'value' => '#0A1020'],
                ['name' => 'Cloud', 'value' => '#F1F5F9']
            ]
        ];

        if (!empty($product->story_heading)) {
            $data['story_heading'] = $product->story_heading;
        }
        if (!empty($product->story_p1)) {
            $data['story_p1'] = $product->story_p1;
        }
        if (!empty($product->story_p2)) {
            $data['story_p2'] = $product->story_p2;
        }

        return $data;
    }
}
