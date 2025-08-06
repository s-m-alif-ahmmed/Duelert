<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeelTopOnTheWorldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('feel_top_on_the_worlds')->updateOrInsert(
            ['id' => 1],
            [
                'title' => 'You can now make your customers feel on top of the world',
                'description' => "Join over 1,000+ businesses never missing important dates in their users\nlives.",
                'image' => 'uploads/FeelTopOnTheWorld/1749711631-subscribe-banner-8k03wix6png.png',
                'button_text' => 'Schedule Now',
                'status' => 'active',
                'created_at' => '2025-06-12 06:08:25',
                'updated_at' => '2025-06-12 07:00:31',
            ]
        );
    }
}
