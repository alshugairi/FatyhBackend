<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('description')->nullable();
            $table->integer('status')->default(0);
            $table->enum('type', ['product'])->default('product');
            $table->string('slug')->nullable()->unique();
            $table->integer('position')->default(0);
            $table->string('icon')->nullable();
            $table->string('image')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('editor_id')->references('id')->on('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
