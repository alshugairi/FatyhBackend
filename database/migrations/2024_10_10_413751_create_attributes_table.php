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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->enum('type', ['select', 'color', 'size'])->default('select');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_required')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->integer('position')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('attribute_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained()->onDelete('cascade');
            $table->json('name');
            $table->string('value')->nullable();
            $table->integer('position')->default(0);
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
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('attribute_options');
    }
};
