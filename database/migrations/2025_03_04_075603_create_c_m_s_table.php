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
        Schema::create('c_m_s', function (Blueprint $table) {
            $table->id();            
            $table->string('home_banner_title')->nullable();
            $table->longText('home_banner_subtitle')->nullable();
            $table->string('button_text')->nullable();
            $table->string('home_banner')->nullable();
            $table->string('home_banner_two')->nullable();
            $table->string('home_banner_three')->nullable();
            $table->string('home_banner_four')->nullable();
            $table->string('home_banner_five')->nullable();
            $table->string('about_page_title')->nullable();
            $table->string('about_page_banner')->nullable();
            $table->string('blog_page_title')->nullable();
            $table->string('blog_page_banner')->nullable();
            $table->string('blog_details_title')->nullable();
            $table->string('blog_details_banner')->nullable();
            $table->string('contact_page_title')->nullable();
            $table->string('contact_page_banner')->nullable();
            $table->string('login_banner')->nullable();
            $table->string('signup_banner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_m_s');
    }
};
