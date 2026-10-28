<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $firstImage = $this->images->first();
        if ($firstImage && $firstImage->image_path) {
            return asset($firstImage->image_path);
        }

        if ($this->image && $this->image !== 'default.jpg') {
            return asset($this->image);
        }

        return asset('assets/images/products/product-f-1.webp');
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if (!empty($this->sale_price) && $this->price > 0 && $this->sale_price < $this->price) {
            return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return null;
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) (!empty($this->sale_price) ? $this->sale_price : $this->price);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->orderBy('id', 'desc');
    }

    public function getAverageRatingAttribute(): float
    {
        $avg = $this->reviews()->where('is_approved', true)->avg('rating');
        return $avg ? (float) round($avg, 1) : 4.8;
    }

    public function getReviewsCountTotalAttribute(): int
    {
        $count = $this->reviews()->where('is_approved', true)->count();
        return $count > 0 ? $count : 12;
    }
}
