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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('code')->unique();
            $table->enum('type', ['percentage', 'fixed_amount']);
            $table->decimal('value', 10, 2);
            $table->unsignedInteger('limit_per_user')->nullable();
            $table->unsignedInteger('max_usage')->nullable();
            $table->unsignedInteger('usage_count')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->json('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('editor_id')->references('id')->on('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
