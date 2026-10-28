<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'country',
        'promotions',
        'order_updates',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'promotions' => 'boolean',
            'order_updates' => 'boolean',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class)->orderBy('is_default', 'desc')->orderBy('id', 'desc');
    }

    public function getDefaultAddressAttribute(): ?UserAddress
    {
        return $this->addresses()->where('is_default', true)->first() ?? $this->addresses()->first();
    }

    public function paymentMethods()
    {
        return $this->hasMany(UserPaymentMethod::class)->orderBy('is_default', 'desc')->orderBy('id', 'desc');
    }

    public function getDefaultPaymentMethodAttribute(): ?UserPaymentMethod
    {
        return $this->paymentMethods()->where('is_default', true)->first() ?? $this->paymentMethods()->first();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->with('product')->orderBy('id', 'desc');
    }
}
