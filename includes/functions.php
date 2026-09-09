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
        $productId = (int) $productId;
        $docRoot = dirname(__DIR__); // Project root directory

        $searchFolders = [
            ['dir' => $docRoot . '/assets/images/products', 'web' => 'assets/images/products/'],
            ['dir' => $docRoot . '/assets/products', 'web' => 'assets/products/']
        ];

        $images = [];

        // Check for images slot 1 up to $maxImages
        for ($i = 1; $i <= $maxImages; $i++) {
            $found = null;

            foreach ($searchFolders as $folder) {
                if (!is_dir($folder['dir'])) {
                    continue;
                }

                $files = scandir($folder['dir']);
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
