<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValueWeOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('value_we_offers')->updateOrInsert(
            ['id' => 1],
            [
                'title' => 'The Value we offer',
                'description' => "Duelert is a calendar tool that alerts businesses of customers' birthday, vehicle renewal alerts and important schedules. It's also a great tool for reminding people of birthdays, anniversaries, appointments and more.",
                'image_one' => 'uploads/valueWeOffer/image_one/1749708797-about-image-c5i4oy3a-1png.png',
                'image_two' => null,
                'created_at' => '2025-06-12 06:08:25',
                'updated_at' => '2025-06-12 06:13:17',
            ]
        );

        // if (!\App\Models\ValueWeOffer::first()) {
        //     \App\Models\ValueWeOffer::create([
        //         'title' => null,
        //         'description' => null,
        //         'image_one' => null,
        //         'image_two' => null,
        //     ]);
        // }
    }
}
