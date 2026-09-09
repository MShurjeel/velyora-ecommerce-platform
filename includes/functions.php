<?php
/**
 * Global Helper Functions for Velyora
 */

if (!function_exists('getProductImages')) {
    /**
     * Dynamically retrieve existing product gallery images (up to $maxImages).
     * Looks for images named P{productId}-img{slot}.* in assets/images/products or assets/products.
     * Only returns images that physically exist.
     *
     * @param int|string $productId
     * @param string $fallbackImage
     * @param int $maxImages
     * @return array List of web-accessible image paths
     */
    function getProductImages($productId, $fallbackImage = '', $maxImages = 4) {
        global $pdo;
        $productId = (int) $productId;
        $docRoot = dirname(__DIR__); // Project root directory

        $images = [];

        // 1. Primary: Fetch directly from product_images database table
        if (isset($pdo) && $pdo instanceof PDO) {
            try {
                $stmt = $pdo->prepare("
                    SELECT image_path 
                    FROM product_images 
                    WHERE product_id = :id 
                    ORDER BY sort_order ASC, is_primary DESC 
                    LIMIT :limit
                ");
                $stmt->bindValue(':id', $productId, PDO::PARAM_INT);
                $stmt->bindValue(':limit', (int) $maxImages, PDO::PARAM_INT);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);

                foreach ($rows as $path) {
                    $systemPath = $docRoot . '/' . ltrim($path, '/');
                    if (file_exists($systemPath)) {
                        $images[] = $path;
                    }
                }

                if (!empty($images)) {
                    return $images;
                }
            } catch (Exception $e) {
                // Silently fallback if table query fails
            }
        }

        // 2. Secondary fallback: Scan folders for matching files
        $searchFolders = [
            ['dir' => $docRoot . '/assets/images/products', 'web' => 'assets/images/products/'],
            ['dir' => $docRoot . '/assets/products', 'web' => 'assets/products/']
        ];

        static $folderCache = [];

        // Check for images slot 1 up to $maxImages
        for ($i = 1; $i <= $maxImages; $i++) {
            $found = null;

            foreach ($searchFolders as $folder) {
                if (!is_dir($folder['dir'])) {
                    continue;
                }

                if (!isset($folderCache[$folder['dir']])) {
                    $folderCache[$folder['dir']] = scandir($folder['dir']);
                }
                $files = $folderCache[$folder['dir']];

                foreach ($files as $file) {
                    if ($file === '.' || $file === '..') {
                        continue;
                    }

                    // Matches e.g. P1-img1.png, P7-img-4.png, P3-img4.jpeg, P9-img-3.png, etc.
                    if (preg_match('/^p' . $productId . '[-_]img[-_]?' . $i . '(\b|[._-])/i', $file)) {
                        // Skip redundant duplicate files with "(2)" if a standard file is found
                        if ($found !== null && strpos($file, '(') !== false) {
                            continue;
                        }
                        $found = $folder['web'] . $file;
                        if (strpos($file, '(') === false) {
                            break 2;
                        }
                    }
                }
            }

            // Only add if the image actually exists
            if ($found) {
                $images[] = $found;
            }
        }

        // If no numbered images were found at all, check fallback from DB
        if (empty($images) && !empty($fallbackImage)) {
            if (strpos($fallbackImage, '/') !== false) {
                $fallbackWeb = $fallbackImage;
                if (file_exists($docRoot . '/' . ltrim($fallbackWeb, '/'))) {
                    $images[] = $fallbackWeb;
                }
            } else {
                foreach ($searchFolders as $folder) {
                    if (file_exists($folder['dir'] . '/' . $fallbackImage)) {
                        $images[] = $folder['web'] . $fallbackImage;
                        break;
                    }
                }
            }
        }

        return $images;
    }
}

if (!function_exists('getProductImage')) {
    /**
     * Retrieve the primary display image for a product.
     *
     * @param int|string $productId
     * @param string $fallbackImage
     * @return string Web path to primary image
     */
    function getProductImage($productId, $fallbackImage = '') {
        $images = getProductImages($productId, $fallbackImage, 4);
        if (!empty($images)) {
            return $images[0];
        }

        return 'assets/images/products/product-f-1.webp';
    }
}

if (!function_exists('getProductDetailsData')) {
    /**
     * Retrieve dynamic, industry-standard product details (Story, Features, What's Included, Specifications, Colors).
     *
     * @param array $product Product row from database
     * @return array Array containing story_heading, story_p1, story_p2, features, included, specifications, colors
     */
    function getProductDetailsData($product) {
        $id = isset($product['id']) ? (int) $product['id'] : 0;
        $name = $product['name'] ?? 'Product';
        $category = $product['category'] ?? 'General';
        $desc = $product['description'] ?? '';

        // Product Catalog Details Map (Tailored for products 1-9)
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
            4 => [
                'story_heading' => 'Refined minimalism crafted for your contemporary space.',
                'story_p1' => 'The Modern Lifestyle Essential brings intentional simplicity into your living or working environment, utilizing timeless geometric shapes and sustainable matte materials.',
                'story_p2' => 'Built with meticulous attention to tactile quality and subtle textures, it effortlessly complements contemporary interior styles while serving a practical everyday purpose.',
                'features' => [
                    ['icon' => 'bi-aspect-ratio', 'title' => 'Timeless Minimalist Aesthetic', 'text' => 'Clean architectural lines and harmonious proportions that elevate any contemporary room.'],
                    ['icon' => 'bi-gem', 'title' => 'Sustainably Sourced Materials', 'text' => 'Crafted from eco-conscious, architectural-grade composite with satin matte finishing.'],
                    ['icon' => 'bi-layers', 'title' => 'Multi-Functional Utility', 'text' => 'Thoughtfully engineered to streamline your everyday routine with intuitive practicality.'],
                    ['icon' => 'bi-shield-check', 'title' => 'Enduring Craftsmanship', 'text' => 'Precision-milled and scratch-resistant to preserve its pristine look through years of use.']
                ],
                'included' => [
                    $name,
                    'Custom Protective Packaging',
                    'Velyora Certificate of Authenticity',
                    'Care & Maintenance Guide'
                ],
                'specifications' => [
                    'Dimensions & Weight' => [
                        'Dimensions' => '18 cm x 12 cm x 8 cm',
                        'Weight' => '450 grams'
                    ],
                    'Materials & Surface' => [
                        'Primary Material' => 'Architectural Matte Ceramic & Brushed Metal',
                        'Coating' => 'Anti-fingerprint Satin Matte Sealant',
                        'Base' => 'Non-marking high-grip silicone pads'
                    ],
                    'General Information' => [
                        'Category' => $category,
                        'Design Origin' => 'Designed in Scandinavia',
                        'Warranty' => '2 Years Limited Warranty'
                    ]
                ],
                'colors' => [
                    ['name' => 'Matte Obsidian', 'value' => '#18181A'],
                    ['name' => 'Arctic White', 'value' => '#ECEFF1']
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
                    ],
                    'Security & Protection' => [
                        'RFID Shielding' => 'Yes (13.56 MHz frequency blocker)',
                        'Category' => $category
                    ]
                ],
                'colors' => [
                    ['name' => 'Gunmetal', 'value' => '#2B2D31'],
                    ['name' => 'Brushed Silver', 'value' => '#D1D5DB'],
                    ['name' => 'Desert Tan', 'value' => '#C2A684']
                ]
            ],
            6 => [
                'story_heading' => 'Bold contours and contemporary urban silhouette.',
                'story_p1' => 'The Modern Street Style collection embodies the energy of modern city life with relaxed tailoring, durable performance fabric, and sharp architectural paneling.',
                'story_p2' => 'Built for movement and versatile layering, it pairs effortlessly with minimal sneakers and technical outer layers for an elevated, clean urban look.',
                'features' => [
                    ['icon' => 'bi-tag', 'title' => 'Architectural Tailoring', 'text' => 'Contemporary silhouette that blends street energy with functional daily mobility.'],
                    ['icon' => 'bi-wind', 'title' => 'Performance Stretch Blend', 'text' => 'Moisture-wicking, flexible ripstop weave that holds crisp shape through all-day wear.'],
                    ['icon' => 'bi-palette', 'title' => 'Subtle Designer Details', 'text' => 'Tonal embroidered micro-branding, matte hardware, and ergonomic contour seams.'],
                    ['icon' => 'bi-arrow-repeat', 'title' => 'Colorfast & Resilient', 'text' => 'Engineered to resist fading and maintain structured fit after countless laundry cycles.']
                ],
                'included' => [
                    $name,
                    'Eco-Friendly Breathable Garment Bag',
                    'Velyora Street Style & Care Guide'
                ],
                'specifications' => [
                    'Fabric & Construction' => [
                        'Material Composition' => '65% Combed Cotton, 35% Technical Nylon Ripstop',
                        'Weave' => 'High-Density Structured Cross-Hatch',
                        'Stretch' => '2-Way Natural Mechanical Stretch'
                    ],
                    'Fit & Styling' => [
                        'Silhouette' => 'Tapered Urban Fit with Relaxed Seat & Thigh',
                        'Waistband' => 'Custom Elasticated Band with Internal Bungee Cord',
                        'Pockets' => '2 Deep Side Hand Pockets, 2 Zippered Utility Pockets'
                    ],
                    'Care Instructions' => [
                        'Washing' => 'Cold wash on gentle cycle, inside out',
                        'Drying' => 'Hang dry in shade; do not tumble dry',
                        'Ironing' => 'Low iron if needed, do not iron over prints'
                    ]
                ],
                'colors' => [
                    ['name' => 'Pitch Black', 'value' => '#111215'],
                    ['name' => 'Concrete Grey', 'value' => '#63666A'],
                    ['name' => 'Dusty Sage', 'value' => '#7A847A']
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
                        'Indicator' => 'Subtle Warm White LED Status Indicator'
                    ],
                    'Chassis & Thermal' => [
                        'Enclosure' => 'Unibody CNC-Machined Anodized Aluminum',
                        'Cooling' => 'Passive Conductive Heat Dissipation',
                        'Dimensions' => '11.2 cm x 4.3 cm x 1.2 cm',
                        'Weight' => '85 grams'
                    ],
                    'Compatibility' => [
                        'Supported OS' => 'macOS 11+, Windows 10/11, iPadOS, ChromeOS, Android',
                        'Driver Requirements' => 'No drivers required (Plug and Play)'
                    ]
                ],
                'colors' => [
                    ['name' => 'Space Grey', 'value' => '#33373E'],
                    ['name' => 'Silver', 'value' => '#E2E5E9']
                ]
            ],
            8 => [
                'story_heading' => 'Transform your living space with purposeful warmth.',
                'story_p1' => 'Crafted to elevate modern interiors, the Contemporary Home Essential combines warm organic undertones with clean structural lines to create a calming focal point in any room.',
                'story_p2' => 'Hand-finished with sustainable, non-toxic materials, it is built to withstand everyday domestic use while maintaining its pristine aesthetic appeal year after year.',
                'features' => [
                    ['icon' => 'bi-house-heart', 'title' => 'Organic Interior Warmth', 'text' => 'Blends natural undertones with crisp architectural geometry to enhance home ambience.'],
                    ['icon' => 'bi-tree', 'title' => 'Responsibly Sourced', 'text' => 'Crafted with FSC-certified sustainable timber and natural low-impact minerals.'],
                    ['icon' => 'bi-stars', 'title' => 'Stain & Scratch Guard', 'text' => 'Eco-friendly protective finish repels household dust, liquid spills, and surface scuffs.'],
                    ['icon' => 'bi-sun', 'title' => 'Versatile Spatial Flow', 'text' => 'Designed to harmonize seamlessly with both minimalist, Scandinavian, and classic decor.']
                ],
                'included' => [
                    $name,
                    'Soft Microfiber Surface Cleaning Cloth',
                    'Anti-Scratch Surface Protection Pads',
                    'Assembly & Care Instructions'
                ],
                'specifications' => [
                    'Materials & Finish' => [
                        'Wood Type' => 'Solid European Oak & Architectural Ceramic',
                        'Surface Treatment' => 'Water-Based Matte Zero-VOC Protective Sealant',
                        'Hardware' => 'Concealed Zinc Alloy Reinforcements'
                    ],
                    'Dimensions & Weight' => [
                        'Dimensions' => '22 cm x 15 cm x 9 cm',
                        'Product Weight' => '680 grams',
                        'Load Bearing' => 'Up to 5 kg static load'
                    ],
                    'Sustainability' => [
                        'Certification' => 'FSC-Certified Responsibly Harvested',
                        'Recyclability' => '100% Recyclable Packaging'
                    ]
                ],
                'colors' => [
                    ['name' => 'Warm Terracotta', 'value' => '#A45D43'],
                    ['name' => 'Natural Oak', 'value' => '#B8976C'],
                    ['name' => 'Sandstone', 'value' => '#E4DACB']
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
                        'Glass' => 'Synthetic Sapphire Crystal Lens'
                    ],
                    'Sensors & Connectivity' => [
                        'Health Sensors' => 'Gen-4 Multi-Channel PPG, Optical SpO2, Skin Temp, ECG',
                        'Navigation' => 'Dual-Band Multi-GNSS (GPS, GLONASS, Galileo, BeiDou)',
                        'Connectivity' => 'Bluetooth 5.3 Low Energy, Wi-Fi 2.4GHz, NFC'
                    ],
                    'Battery & Durability' => [
                        'Battery Life' => 'Up to 14 days (typical use) / 7 days (heavy use with GPS)',
                        'Charging Time' => '60 minutes via magnetic fast-charging cradle',
                        'Water Resistance' => '5 ATM (Water-resistant up to 50 meters)'
                    ],
                    'Compatibility' => [
                        'Companion App' => 'Velyora Health App for iOS (14.0+) & Android (8.0+)',
                        'Notifications' => 'Calls, SMS, App Alerts, Quick Replies'
                    ]
                ],
                'colors' => [
                    ['name' => 'Midnight Titanium', 'value' => '#1D2024'],
                    ['name' => 'Raw Brushed Titanium', 'value' => '#A8ACB4']
                ]
            ]
        ];

        // If defined in catalog, use it
        if (isset($catalog[$id])) {
            $data = $catalog[$id];
        } else {
            // Intelligent fallback for any newly added product
            $data = [
                'story_heading' => 'Crafted for elevated modern living.',
                'story_p1' => !empty($desc) ? $desc : "The {$name} represents Velyora's commitment to quality craftsmanship and understated modern aesthetics.",
                'story_p2' => 'Engineered with precision materials and functional design, it seamlessly integrates into your daily life with enduring performance and style.',
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
        }

        // Always prioritize database values if story_heading, story_p1, story_p2 are populated in DB
        if (!empty($product['story_heading'])) {
            $data['story_heading'] = $product['story_heading'];
        }
        if (!empty($product['story_p1'])) {
            $data['story_p1'] = $product['story_p1'];
        }
        if (!empty($product['story_p2'])) {
            $data['story_p2'] = $product['story_p2'];
        }

        return $data;
    }
}

/* =========================================================
   CART & WISHLIST HELPER FUNCTIONS
========================================================= */

if (!function_exists('getUserSessionId')) {
    /**
     * Get or initialize the active user session ID.
     */
    function getUserSessionId() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return session_id();
    }
}

if (!function_exists('getCartItems')) {
    /**
     * Get all cart items for the current session with resolved product and category info.
     */
    function getCartItems() {
        global $pdo;
        $sessionId = getUserSessionId();
        if (!$pdo || empty($sessionId)) {
            return [];
        }

        try {
            $stmt = $pdo->prepare("
                SELECT 
                    c.id AS cart_id,
                    c.session_id,
                    c.product_id,
                    c.quantity,
                    c.created_at,
                    p.name,
                    p.price AS original_price,
                    p.sale_price,
                    p.stock_qty,
                    p.image,
                    p.status,
                    COALESCE(cat.name, 'General') AS category_name
                FROM cart c
                INNER JOIN products p ON c.product_id = p.id
                LEFT JOIN categories cat ON p.category_id = cat.id
                WHERE c.session_id = :session_id
                ORDER BY c.id DESC
            ");
            $stmt->execute([':session_id' => $sessionId]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $items = [];
            foreach ($rows as $row) {
                $hasSale = !empty($row['sale_price']) && (float)$row['sale_price'] > 0 && (float)$row['sale_price'] < (float)$row['original_price'];
                $price = $hasSale ? (float)$row['sale_price'] : (float)$row['original_price'];
                $oldPrice = $hasSale ? (float)$row['original_price'] : null;

                $items[] = [
                    'id' => (int)$row['cart_id'],
                    'cart_id' => (int)$row['cart_id'],
                    'product_id' => (int)$row['product_id'],
                    'name' => $row['name'],
                    'category' => $row['category_name'],
                    'category_name' => $row['category_name'],
                    'variant' => 'Standard',
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'quantity' => (int)$row['quantity'],
                    'stock_qty' => (int)$row['stock_qty'],
                    'image' => getProductImage($row['product_id'], $row['image']),
                    'item_total' => $price * (int)$row['quantity']
                ];
            }
            return $items;
        } catch (Exception $e) {
            error_log('getCartItems error: ' . $e->getMessage());
            return [];
        }
    }
}

if (!function_exists('getCartTotals')) {
    /**
     * Calculate subtotal, delivery, tax, discount, and grand total for current cart.
     */
    function getCartTotals() {
        $items = getCartItems();
        $subtotal = 0;
        $itemCount = 0;

        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $itemCount += $item['quantity'];
        }

        $freeShippingThreshold = 3000;
        $shipping = ($subtotal >= $freeShippingThreshold || $subtotal == 0) ? 0 : 250;
        $discount = 0;
        $tax = round(($subtotal - $discount) * 0.02);
        $total = $subtotal + $shipping + $tax - $discount;

        $progressPercent = $subtotal >= $freeShippingThreshold ? 100 : round(($subtotal / $freeShippingThreshold) * 100);
        $amountForFreeShipping = max(0, $freeShippingThreshold - $subtotal);

        return [
            'subtotal' => $subtotal,
            'subtotal_formatted' => 'Rs. ' . number_format($subtotal),
            'shipping' => $shipping,
            'shipping_formatted' => $shipping === 0 ? 'FREE' : 'Rs. ' . number_format($shipping),
            'free_shipping_threshold' => $freeShippingThreshold,
            'free_shipping_unlocked' => $subtotal >= $freeShippingThreshold,
            'progress_percent' => $progressPercent,
            'amount_for_free_shipping' => $amountForFreeShipping,
            'tax' => $tax,
            'tax_formatted' => 'Rs. ' . number_format($tax),
            'discount' => $discount,
            'discount_formatted' => 'Rs. ' . number_format($discount),
            'total' => $total,
            'total_formatted' => 'Rs. ' . number_format($total),
            'item_count' => $itemCount
        ];
    }
}

if (!function_exists('getCartCount')) {
    /**
     * Get total number of items in the cart for current session.
     */
    function getCartCount() {
        global $pdo;
        $sessionId = getUserSessionId();
        if (!$pdo || empty($sessionId)) {
            return 0;
        }

        try {
            $stmt = $pdo->prepare("SELECT COALESCE(SUM(quantity), 0) FROM cart WHERE session_id = :session_id");
            $stmt->execute([':session_id' => $sessionId]);
            return (int)$stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }
}

if (!function_exists('addToCart')) {
    /**
     * Add a product with quantity to user's cart.
     */
    function addToCart($productId, $quantity = 1) {
        global $pdo;
        $productId = (int)$productId;
        $quantity = max(1, (int)$quantity);
        $sessionId = getUserSessionId();

        if (!$pdo || empty($sessionId) || $productId <= 0) {
            return ['success' => false, 'message' => 'Invalid product or session.'];
        }

        try {
            // Check product availability
            $pStmt = $pdo->prepare("SELECT id, name, stock_qty FROM products WHERE id = :id");
            $pStmt->execute([':id' => $productId]);
            $product = $pStmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                return ['success' => false, 'message' => 'Product not found.'];
            }

            if ($product['stock_qty'] <= 0) {
                return ['success' => false, 'message' => 'Sorry, this product is out of stock.'];
            }

            // Check if already in cart
            $cStmt = $pdo->prepare("SELECT id, quantity FROM cart WHERE session_id = :session_id AND product_id = :product_id");
            $cStmt->execute([':session_id' => $sessionId, ':product_id' => $productId]);
            $existing = $cStmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                $newQty = $existing['quantity'] + $quantity;
                if ($newQty > $product['stock_qty']) {
                    $newQty = $product['stock_qty'];
                }
                $uStmt = $pdo->prepare("UPDATE cart SET quantity = :qty WHERE id = :id");
                $uStmt->execute([':qty' => $newQty, ':id' => $existing['id']]);
            } else {
                $addQty = min($quantity, $product['stock_qty']);
                $iStmt = $pdo->prepare("INSERT INTO cart (session_id, product_id, quantity) VALUES (:session_id, :product_id, :quantity)");
                $iStmt->execute([':session_id' => $sessionId, ':product_id' => $productId, ':quantity' => $addQty]);
            }

            $totals = getCartTotals();
            return [
                'success' => true,
                'message' => '“' . $product['name'] . '” added to your cart!',
                'cart_count' => $totals['item_count'],
                'totals' => $totals
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}

if (!function_exists('updateCartQuantity')) {
    /**
     * Update quantity of a specific cart row.
     */
    function updateCartQuantity($cartId, $quantity) {
        global $pdo;
        $cartId = (int)$cartId;
        $quantity = (int)$quantity;
        $sessionId = getUserSessionId();

        if (!$pdo || empty($sessionId) || $cartId <= 0) {
            return ['success' => false, 'message' => 'Invalid parameters.'];
        }

        try {
            if ($quantity <= 0) {
                return removeFromCart($cartId);
            }

            // Check row ownership and stock
            $stmt = $pdo->prepare("
                SELECT c.id, c.product_id, p.stock_qty, p.name 
                FROM cart c 
                INNER JOIN products p ON c.product_id = p.id 
                WHERE c.id = :id AND c.session_id = :session_id
            ");
            $stmt->execute([':id' => $cartId, ':session_id' => $sessionId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return ['success' => false, 'message' => 'Cart item not found.'];
            }

            $targetQty = min($quantity, $row['stock_qty']);
            $uStmt = $pdo->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id AND session_id = :session_id");
            $uStmt->execute([':quantity' => $targetQty, ':id' => $cartId, ':session_id' => $sessionId]);

            $totals = getCartTotals();
            return [
                'success' => true,
                'message' => 'Cart updated.',
                'quantity' => $targetQty,
                'cart_count' => $totals['item_count'],
                'totals' => $totals
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}

if (!function_exists('removeFromCart')) {
    /**
     * Remove a specific item from cart.
     */
    function removeFromCart($cartId) {
        global $pdo;
        $cartId = (int)$cartId;
        $sessionId = getUserSessionId();

        if (!$pdo || empty($sessionId) || $cartId <= 0) {
            return ['success' => false, 'message' => 'Invalid item.'];
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM cart WHERE id = :id AND session_id = :session_id");
            $stmt->execute([':id' => $cartId, ':session_id' => $sessionId]);

            $totals = getCartTotals();
            return [
                'success' => true,
                'message' => 'Item removed from your cart.',
                'cart_count' => $totals['item_count'],
                'totals' => $totals
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}

if (!function_exists('clearCart')) {
    /**
     * Empty entire cart for the current session.
     */
    function clearCart() {
        global $pdo;
        $sessionId = getUserSessionId();
        if (!$pdo || empty($sessionId)) {
            return ['success' => false, 'message' => 'Invalid session.'];
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM cart WHERE session_id = :session_id");
            $stmt->execute([':session_id' => $sessionId]);

            $totals = getCartTotals();
            return [
                'success' => true,
                'message' => 'Your cart has been cleared.',
                'cart_count' => 0,
                'totals' => $totals
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}

if (!function_exists('getWishlistItems')) {
    /**
     * Retrieve all wishlist items for current session with resolved product data.
     */
    function getWishlistItems() {
        global $pdo;
        $sessionId = getUserSessionId();
        if (!$pdo || empty($sessionId)) {
            return [];
        }

        try {
            $stmt = $pdo->prepare("
                SELECT 
                    w.id AS wishlist_id,
                    w.session_id,
                    w.product_id,
                    w.created_at,
                    p.name,
                    p.price AS original_price,
                    p.sale_price,
                    p.stock_qty,
                    p.image,
                    p.status,
                    COALESCE(cat.name, 'General') AS category_name
                FROM wishlist w
                INNER JOIN products p ON w.product_id = p.id
                LEFT JOIN categories cat ON p.category_id = cat.id
                WHERE w.session_id = :session_id
                ORDER BY w.id DESC
            ");
            $stmt->execute([':session_id' => $sessionId]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $items = [];
            foreach ($rows as $row) {
                $hasSale = !empty($row['sale_price']) && (float)$row['sale_price'] > 0 && (float)$row['sale_price'] < (float)$row['original_price'];
                $price = $hasSale ? (float)$row['sale_price'] : (float)$row['original_price'];
                $oldPrice = $hasSale ? (float)$row['original_price'] : null;

                $items[] = [
                    'id' => (int)$row['wishlist_id'],
                    'wishlist_id' => (int)$row['wishlist_id'],
                    'product_id' => (int)$row['product_id'],
                    'name' => $row['name'],
                    'category_name' => $row['category_name'],
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'stock_qty' => (int)$row['stock_qty'],
                    'in_stock' => (int)$row['stock_qty'] > 0,
                    'image' => getProductImage($row['product_id'], $row['image'])
                ];
            }
            return $items;
        } catch (Exception $e) {
            error_log('getWishlistItems error: ' . $e->getMessage());
            return [];
        }
    }
}

if (!function_exists('getWishlistCount')) {
    /**
     * Get count of items in wishlist for current session.
     */
    function getWishlistCount() {
        global $pdo;
        $sessionId = getUserSessionId();
        if (!$pdo || empty($sessionId)) {
            return 0;
        }

        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM wishlist WHERE session_id = :session_id");
            $stmt->execute([':session_id' => $sessionId]);
            return (int)$stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }
}

if (!function_exists('isInWishlist')) {
    /**
     * Check if a product is in the current session's wishlist.
     */
    function isInWishlist($productId) {
        global $pdo;
        $productId = (int)$productId;
        $sessionId = getUserSessionId();
        if (!$pdo || empty($sessionId) || $productId <= 0) {
            return false;
        }

        try {
            $stmt = $pdo->prepare("SELECT id FROM wishlist WHERE session_id = :session_id AND product_id = :product_id LIMIT 1");
            $stmt->execute([':session_id' => $sessionId, ':product_id' => $productId]);
            return (bool)$stmt->fetchColumn();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('toggleWishlist')) {
    /**
     * Toggle product in user's wishlist (adds if absent, removes if present).
     */
    function toggleWishlist($productId) {
        global $pdo;
        $productId = (int)$productId;
        $sessionId = getUserSessionId();

        if (!$pdo || empty($sessionId) || $productId <= 0) {
            return ['success' => false, 'message' => 'Invalid product or session.'];
        }

        try {
            $checkStmt = $pdo->prepare("SELECT id FROM wishlist WHERE session_id = :session_id AND product_id = :product_id");
            $checkStmt->execute([':session_id' => $sessionId, ':product_id' => $productId]);
            $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                // Remove
                $delStmt = $pdo->prepare("DELETE FROM wishlist WHERE id = :id");
                $delStmt->execute([':id' => $existing['id']]);
                $count = getWishlistCount();
                return [
                    'success' => true,
                    'action' => 'removed',
                    'in_wishlist' => false,
                    'message' => 'Removed from wishlist.',
                    'wishlist_count' => $count
                ];
            } else {
                // Check product exists
                $pStmt = $pdo->prepare("SELECT name FROM products WHERE id = :id");
                $pStmt->execute([':id' => $productId]);
                $name = $pStmt->fetchColumn();

                $insStmt = $pdo->prepare("INSERT INTO wishlist (session_id, product_id) VALUES (:session_id, :product_id)");
                $insStmt->execute([':session_id' => $sessionId, ':product_id' => $productId]);
                $count = getWishlistCount();
                return [
                    'success' => true,
                    'action' => 'added',
                    'in_wishlist' => true,
                    'message' => '“' . ($name ?: 'Product') . '” added to your wishlist!',
                    'wishlist_count' => $count
                ];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}

if (!function_exists('removeFromWishlist')) {
    /**
     * Remove a product from wishlist.
     */
    function removeFromWishlist($productId) {
        global $pdo;
        $productId = (int)$productId;
        $sessionId = getUserSessionId();

        if (!$pdo || empty($sessionId) || $productId <= 0) {
            return ['success' => false, 'message' => 'Invalid item.'];
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM wishlist WHERE session_id = :session_id AND product_id = :product_id");
            $stmt->execute([':session_id' => $sessionId, ':product_id' => $productId]);

            return [
                'success' => true,
                'message' => 'Item removed from wishlist.',
                'wishlist_count' => getWishlistCount()
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}

if (!function_exists('addAllWishlistToCart')) {
    /**
     * Add all in-stock wishlist items to cart.
     */
    function addAllWishlistToCart() {
        $wishlistItems = getWishlistItems();
        $added = 0;

        foreach ($wishlistItems as $item) {
            if ($item['in_stock']) {
                addToCart($item['product_id'], 1);
                $added++;
            }
        }

        $totals = getCartTotals();
        return [
            'success' => true,
            'added_count' => $added,
            'message' => $added > 0 ? "Added {$added} item(s) from wishlist to your cart!" : "No in-stock items to add.",
            'cart_count' => $totals['item_count'],
            'totals' => $totals
        ];
    }
}


