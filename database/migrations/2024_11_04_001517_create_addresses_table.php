<?php

use Illuminate\{Database\Migrations\Migration, Database\Schema\Blueprint, Support\Facades\Schema};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('full_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->enum('address_type', ['billing', 'shipping'])->default('shipping')->index();
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('postal_code')->nullable();
            $table->boolean('is_default')->default(false)->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
