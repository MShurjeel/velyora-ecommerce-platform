<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add phone and order_updates to users table if missing
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'order_updates')) {
                $table->boolean('order_updates')->default(true)->after('promotions');
            }
        });

        // 2. User Addresses table
        if (!Schema::hasTable('user_addresses')) {
            Schema::create('user_addresses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('title')->default('Home'); // Home, Office, Other
                $table->string('recipient_name');
                $table->string('phone');
                $table->string('address_line1');
                $table->string('address_line2')->nullable();
                $table->string('city');
                $table->string('state')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('country')->default('Pakistan');
                $table->boolean('is_default')->default(false);
                $table->timestamps();
            });
        }

        // 3. User Payment Methods table
        if (!Schema::hasTable('user_payment_methods')) {
            Schema::create('user_payment_methods', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('card_type')->default('Visa');
                $table->string('cardholder_name');
                $table->string('card_last_four', 4);
                $table->string('expiry_month', 2);
                $table->string('expiry_year', 4);
                $table->boolean('is_default')->default(false);
                $table->timestamps();
            });
        }

        // 4. Reviews table
        if (!Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->unsignedTinyInteger('rating')->default(5);
                $table->text('comment');
                $table->boolean('is_approved')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('user_payment_methods');
        Schema::dropIfExists('user_addresses');
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('users', 'order_updates')) {
                $table->dropColumn('order_updates');
            }
        });
    }
};

