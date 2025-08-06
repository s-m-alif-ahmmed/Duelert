<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', [
                'facebook',
                'twitter',
                'instagram'
            ]);
            $table->string('link');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        DB::table('social_media')->insert([
            [
                'platform' => 'facebook',
                'link' => 'https://www.facebook.com/',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform' => 'twitter',
                'link' => 'https://www.twitter.com/',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform' => 'instagram',
                'link' => 'https://www.instagram.com/',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};
