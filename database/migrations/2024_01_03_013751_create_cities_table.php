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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
