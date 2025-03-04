<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UserType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->nullable()->index()->constrained('businesses')->nullOnDelete();
            $table->string('name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nickname')->nullable();
            $table->integer('type')->default(UserType::CLIENT->value)->index();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['male', 'female'])->default('male')->index();
            $table->integer('country_id')->nullable()->index();
            $table->integer('city_id')->nullable()->index();
            $table->integer('status')->default(UserType::CLIENT->value)->index();
            $table->string('email')->unique()->nullable()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->decimal('wallet', 10, 2)->nullable();
            $table->string('timezone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
