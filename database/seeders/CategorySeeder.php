<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'Electronics',
                'slug' => 'electronics',
                'icon' => 'bi-laptop',
                'status' => 'active',
            ],
            [
                'id' => 2,
                'name' => 'Fashion',
                'slug' => 'fashion',
                'icon' => 'bi-bag-check',
                'status' => 'active',
            ],
            [
                'id' => 3,
                'name' => 'Beauty',
                'slug' => 'beauty',
                'icon' => 'bi-stars',
                'status' => 'active',
            ],
            [
                'id' => 4,
                'name' => 'Home & Living',
                'slug' => 'home-living',
                'icon' => 'bi-house-door',
                'status' => 'active',
            ],
            [
                'id' => 5,
                'name' => 'Accessories',
                'slug' => 'accessories',
                'icon' => 'bi-watch',
                'status' => 'active',
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['id' => $cat['id']], $cat);
        }
    }
}

