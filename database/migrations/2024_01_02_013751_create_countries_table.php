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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('timezone',)->nullable();
            $table->json('nationality')->nullable();
            $table->string('iso2')->unique()->index()->nullable();
            $table->string('iso3')->nullable()->unique()->index();
            $table->string('dial_code')->nullable();
            $table->integer('priority')->nullable();
            $table->string('flag_emoji')->nullable();
            $table->string('flag_emoji_unicode')->nullable();
            $table->integer('status')->default(0);

            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('set null');

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
        Schema::dropIfExists('countries');
    }
};
