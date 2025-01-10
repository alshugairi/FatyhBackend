<?php

use Illuminate\{Database\Migrations\Migration, Database\Schema\Blueprint, Support\Facades\Schema};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('position')->nullable(); // 'primary', 'footer', 'topbar'
            $table->string('code')->nullable()->unique()->index();
            $table->boolean('status')->default(0)->index();
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->onDelete('cascade');
            $table->json('name')->nullable();
            $table->string('translation_key')->nullable();
            $table->string('type'); // static, category, brand, etc.
            $table->unsignedBigInteger('related_id')->nullable();
            $table->string('url');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menus');
    }
};
