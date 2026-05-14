<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->unsignedBigInteger('product_id')->index();
            $blueprint->string('image_path');
            $blueprint->boolean('is_primary')->default(false);
            $blueprint->timestamps();

            $blueprint->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
