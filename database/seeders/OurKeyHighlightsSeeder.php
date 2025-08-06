<?php

namespace Database\Seeders;

use App\Models\OurKeyHighlight;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OurKeyHighlightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'title' => 'Our key highlights',
                'subtitle' => 'This is what makes us the best',
                'status' => 'active',
                'image' => 'uploads/OurKeyHighlight/1749785972-screenshot-1png.png',
                'body_title' => 'Fast Scheduling',
                'icon' => 'uploads/OurKeyHighlight/icon/1749785972-download-1png.png',
                'description' => 'It takes just a few clicks to set your schedules and reminders',
                'created_at' => '2025-06-13 09:31:51',
                'updated_at' => '2025-06-13 09:39:32',
            ],
            [
                'id' => 2,
                'title' => 'Our key highlights',
                'subtitle' => 'This is what makes us the best',
                'status' => 'active',
                'image' => 'uploads/OurKeyHighlight/1749785948-screenshot-1png.png',
                'body_title' => 'Available Space',
                'icon' => 'uploads/OurKeyHighlight/icon/1749785641-download-2png.png',
                'description' => 'Just enough space and storage to save your customers’ data and dates',
                'created_at' => '2025-06-13 09:34:01',
                'updated_at' => '2025-06-13 09:39:08',
            ],
            [
                'id' => 3,
                'title' => 'Our key Highlights',
                'subtitle' => 'This is what makes us the best',
                'status' => 'active',
                'image' => 'uploads/OurKeyHighlight/1749785838-screenshot-1png.png',
                'body_title' => 'Afforfable and Easy',
                'icon' => 'uploads/OurKeyHighlight/icon/1749785838-download-3png.png',
                'description' => 'Very affordable Prices and easy to use interface',
                'created_at' => '2025-06-13 09:37:18',
                'updated_at' => '2025-06-13 09:37:18',
            ],
        ];

        foreach ($data as $item) {
            OurKeyHighlight::firstOrCreate(['id' => $item['id']], $item);
        }
    }
}
