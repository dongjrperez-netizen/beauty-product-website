<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')
                ->nullable()
                ->index()
                ->constrained('categories')
                ->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('product_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')
                ->nullable()
                ->index()
                ->constrained('brands')
                ->nullOnDelete();
            $table->foreignId('category_id')
                ->index()
                ->constrained('categories')
                ->restrictOnDelete();
            $table->foreignId('condition_id')
                ->nullable()
                ->index()
                ->constrained('product_conditions')
                ->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->index()
                ->constrained('products')
                ->cascadeOnDelete();
            $table->string('sku')->nullable()->unique();
            $table->string('variant_name')->nullable();
            $table->decimal('size_value', 10, 2)->nullable();
            $table->string('size_unit')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->boolean('is_price_on_request')->default(false);
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->boolean('track_stock')->default(false);
            $table->boolean('is_default')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->index()
                ->constrained('products')
                ->cascadeOnDelete();
            $table->foreignId('product_variant_id')
                ->nullable()
                ->index()
                ->constrained('product_variants')
                ->nullOnDelete();
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->boolean('is_primary')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('product_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->index()
                ->constrained('products')
                ->cascadeOnDelete();
            $table->foreignId('badge_id')
                ->constrained('badges')
                ->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['product_id', 'badge_id']);
        });

        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('product_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->index()
                ->constrained('products')
                ->cascadeOnDelete();
            $table->foreignId('ingredient_id')
                ->constrained('ingredients')
                ->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['product_id', 'ingredient_id']);
        });

        Schema::create('benefits', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('product_benefits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->index()
                ->constrained('products')
                ->cascadeOnDelete();
            $table->foreignId('benefit_id')
                ->constrained('benefits')
                ->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['product_id', 'benefit_id']);
        });

        Schema::create('skin_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('product_skin_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->index()
                ->constrained('products')
                ->cascadeOnDelete();
            $table->foreignId('skin_type_id')
                ->constrained('skin_types')
                ->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['product_id', 'skin_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_skin_types');
        Schema::dropIfExists('skin_types');
        Schema::dropIfExists('product_benefits');
        Schema::dropIfExists('benefits');
        Schema::dropIfExists('product_ingredients');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('product_badges');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_conditions');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('brands');
    }
};
