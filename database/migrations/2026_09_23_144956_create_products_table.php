<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create("products", function (Blueprint $table) {
            $table->id();
            $table->foreignId("category_id")->constrained("categories")->onDelete("cascade");
            $table->string("name");
            $table->text("description")->nullable();
            $table->string("story_heading")->nullable();
            $table->text("story_p1")->nullable();
            $table->text("story_p2")->nullable();
            $table->decimal("price", 10, 2);
            $table->decimal("sale_price", 10, 2)->nullable();
            $table->integer("stock_qty")->default(0);
            $table->string("image")->default("default.jpg");
            $table->boolean("is_featured")->default(false);
            $table->enum("status", ["active", "draft", "out_of_stock"])->default("active");
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists("products");
    }
};
