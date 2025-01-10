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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()->index();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('customer_email')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();

            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_postcode')->nullable();

            $table->string('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('shipping_postcode')->nullable();

            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->string('discount_code')->nullable();
            $table->decimal('total', 10, 2);

            $table->enum('payment_status', ['pending', 'paid', 'partially_paid', 'refunded', 'failed'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable();
            $table->decimal('paid_amount', 10, 2)->default(0);

            $table->enum('status', [
                'pending_payment',
                'payment_failed',
                'payment_confirmed',
                'confirmed',
                'in_preparation',
                'awaiting_pickup',
                'shipped',
                'in_transit',
                'out_for_delivery',
                'delivered',
                'canceled',
                'return_requested',
                'returned',
                'refund_requested',
                'refunded',
                'rejected',
                'lost_in_transit'
            ])->default('pending_payment');

            $table->string('payment_session_id')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('tracking_number')->nullable();
            $table->json('shipping_metadata')->nullable();

            $table->text('customer_notes')->nullable();
            $table->text('admin_notes')->nullable();

            $table->enum('platform', ['web', 'android', 'ios', 'pos','tablet'])->default('pos');
            $table->foreignId('creator_id')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained();
            $table->foreignId('product_variant_id')->nullable()->constrained();
            $table->string('name');
            $table->string('sku');
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->json('options')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
