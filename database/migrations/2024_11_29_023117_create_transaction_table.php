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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()->index();
            $table->enum('type', ['debit', 'credit']); // debit (money in), credit (money out)
            $table->string('reference_type')->nullable(); // order, purchase, payment
            $table->string('reference_id')->nullable()->index();
            $table->decimal('amount', 10, 2);
            $table->decimal('balance', 10, 2);
            $table->string('payment_method')->nullable(); // cash, bank, stripe, etc
            $table->string('details')->nullable(); // payment reference, transaction id, etc
            $table->string('notes')->nullable();
            $table->foreignId('creator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
