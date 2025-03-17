<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->index()->constrained()->cascadeOnDelete();
            $table->json('name');
            $table->string('sku')->unique()->index();
            $table->string('slug')->unique()->nullable()->index();
            $table->json('description')->nullable();
            $table->json('short_description')->nullable();
            $table->integer('status')->default(0)->index();
            $table->integer('is_featured')->default(0)->index();
            $table->string('barcode')->nullable();

            $table->decimal('sell_price', 10, 2);
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->unsignedInteger('stock_quantity')->nullable();
            $table->boolean('has_variants')->default(false)->index();

            $table->foreignId('category_id')->nullable()->index()->constrained('categories')->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->index()->constrained('brands')->onDelete('set null');
            $table->foreignId('parent_product_id')->nullable()->constrained('products')->onDelete('cascade');

            $table->decimal('rating', 2, 1)->default(0.0)->index();
            $table->string('image')->nullable();
            $table->json('gallery_images')->nullable();

            $table->unsignedInteger('favourites_count')->default(0)->index();

            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();

            $table->foreignId('creator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('editor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
