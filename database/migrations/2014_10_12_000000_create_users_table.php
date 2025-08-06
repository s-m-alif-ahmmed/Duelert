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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->string('cover_photo')->nullable();
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('phone')->nullable();     
            $table->bigInteger('message_limit')->nullable();            
            $table->string('position')->nullable();
            $table->string('about')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('flag')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();            
            $table->string('zip_code', 10)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('password_reset_token')->nullable();
            $table->timestamp('password_reset_token_expiry')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
