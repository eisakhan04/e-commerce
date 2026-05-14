<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->unsignedBigInteger('category_id')->index();
            $blueprint->string('name');
            $blueprint->string('slug')->unique()->index();
            $blueprint->string('sku')->unique()->index();
            $blueprint->text('short_description')->nullable();
            $blueprint->longText('description')->nullable();
            $blueprint->decimal('price', 15, 2)->default(0);
            $blueprint->decimal('discount_price', 15, 2)->nullable();
            $blueprint->decimal('cost_price', 15, 2)->nullable();
            $blueprint->integer('stock')->default(0);
            $blueprint->integer('min_stock_alert')->default(5);
            $blueprint->string('thumbnail')->nullable();
            $blueprint->decimal('weight', 10, 2)->nullable();
            $blueprint->enum('status', ['draft', 'active', 'inactive'])->default('draft')->index();
            $blueprint->boolean('featured')->default(false)->index();
            $blueprint->unsignedBigInteger('views')->default(0);
            $blueprint->timestamps();

            $blueprint->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
