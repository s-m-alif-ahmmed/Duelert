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
        Schema::table('dk_subscriptions', function (Blueprint $table) {
            $table->enum('type',['paid','free'])->default('paid')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dk_subscriptions', function (Blueprint $table) {
            $table->dropColumn("type");
        });
    }
};
