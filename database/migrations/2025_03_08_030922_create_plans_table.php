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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('currency')->nullable();
            $table->decimal('price', 10, 2)->nullable()->default(0);
            // $table->enum('type', ['starter', 'professional', 'company'])->nullable()->unique();
            $table->enum('type', ['free', 'starter', 'professional', 'company']);
            $table->string('title')->nullable();
            $table->integer('customers_limit')->nullable();
            $table->integer('storage_limit')->nullable();
            $table->integer('sms_limit')->nullable(); // SMS per month
            $table->string('customize_birth_message')->nullable();
            $table->string('plan_code')->nullable(); //come will be paystack plan code 
            $table->enum('status', ['active', 'inactive'])->default('active');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
