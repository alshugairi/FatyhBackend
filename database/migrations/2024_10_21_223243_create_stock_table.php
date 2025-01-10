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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('product_variant_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('reference_type')->nullable();
            $table->string('reference_id')->nullable();
            $table->enum('type', ['purchase', 'sale', 'return', 'adjustment', 'transfer', 'initial']);
            $table->integer('quantity_change');
            $table->integer('quantity_before');
            $table->integer('quantity_after');
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('movement_date');
            $table->foreignId('creator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('stock_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('product_variant_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('reservation_type');
            $table->string('reference_id');
            $table->integer('quantity');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->timestamps();
        });

        Schema::create('stock_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('product_variant_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('alert_threshold');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_triggered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('stock_reservations');
        Schema::dropIfExists('stock_alerts');
    }
};
