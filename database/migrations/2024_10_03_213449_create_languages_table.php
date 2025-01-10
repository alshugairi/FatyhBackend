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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('languages');
    }
};
