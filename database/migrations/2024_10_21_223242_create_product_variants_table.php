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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('sku')->unique()->index();
            $table->decimal('sell_price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->json('image_urls')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_variant_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->constrained()->onDelete('cascade');
            $table->foreignId('attribute_id')->constrained()->onDelete('cascade');
            $table->foreignId('attribute_option_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['product_variant_id', 'attribute_id', 'attribute_option_id'], 'variant_attribute_option_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_variant_attributes');
    }
};
