<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('name');
            $blueprint->string('slug')->unique()->index();
            $blueprint->text('description')->nullable();
            $blueprint->string('image')->nullable();
            $blueprint->unsignedBigInteger('parent_id')->nullable()->index();
            $blueprint->enum('status', ['active', 'inactive'])->default('active')->index();
            $blueprint->integer('sort_order')->default(0);
            
            // SEO Fields
            $blueprint->string('meta_title')->nullable();
            $blueprint->text('meta_description')->nullable();
            
            $blueprint->timestamps();

            // Foreign key for self-referencing
            $blueprint->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
