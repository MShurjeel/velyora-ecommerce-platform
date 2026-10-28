<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create("orders", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained("users")->onDelete("set null");
            $table->string("order_number", 50)->unique();
            $table->string("customer_name", 120);
            $table->string("email", 120);
            $table->string("phone", 30);
            $table->text("address");
            $table->string("city", 60);
            $table->string("province", 60)->nullable();
            $table->string("postal_code", 20)->nullable();
            $table->decimal("subtotal", 10, 2);
            $table->decimal("shipping", 10, 2)->default(0);
            $table->decimal("tax", 10, 2)->default(0);
            $table->decimal("total_amount", 10, 2);
            $table->string("payment_method", 50)->default("Cash on Delivery");
            $table->string("payment_status", 30)->default("Pending");
            $table->string("order_status", 30)->default("Processing");
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists("orders");
    }
};
