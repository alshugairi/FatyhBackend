<?php

use Illuminate\{Database\Migrations\Migration, Database\Schema\Blueprint, Support\Facades\Schema};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('collection_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->unsignedBigInteger('creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');

            $table->unique(['collection_id', 'product_id']);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_products');
    }
};
