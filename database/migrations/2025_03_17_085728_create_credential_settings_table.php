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
        Schema::create('credential_settings', function (Blueprint $table) {
            $table->id();
            $table->string('callback_url')->nullable();
            $table->string('paystack_public_key')->nullable();
            $table->string('paystack_secret_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credential_settings');
    }
};
