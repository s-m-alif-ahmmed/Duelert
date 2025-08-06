<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeelTopOnTheWorld extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!\App\Models\FeelTopOnTheWorld::exists()) {
            \App\Models\FeelTopOnTheWorld::create([
                'title' => 'Feel on Top of the World with Our Services',
                'description' => 'Discover how our expert solutions elevate your business to new heights. Join hundreds of satisfied clients who have transformed their digital presence with us.',
                'image' => "uploads/FeelTopOnTheWorld/1749711631-subscribe-banner-8k03wix6png.png",
                'button_text' => 'Schedule Now',
                'status' => 'active'
            ]);
        }
    }
}
