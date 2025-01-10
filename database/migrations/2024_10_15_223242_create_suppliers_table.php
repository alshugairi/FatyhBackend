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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('email')->unique()->index();
            $table->string('phone')->nullable()->index();
            $table->json('company_name')->nullable();
            $table->json('address')->nullable();
            $table->string('image')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('tax_id')->nullable();
            $table->integer('status')->default('0')->index();

            $table->json('additional_info')->nullable();

            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('creator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('editor_id')->nullable()->constrained('users')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
