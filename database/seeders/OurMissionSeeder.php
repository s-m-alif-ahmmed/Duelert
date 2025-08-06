<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OurMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!DB::table('our_missions')->exists()) {
            DB::table('our_missions')->insert([
                'title' => 'Our Mission',
                'description' => "Customers are important to companies and they should be treated with a little love and affection. Duelert is an application that reminds the customer of their birthday, anniversaries and other important events on the customer's calendar. Customers can also add their own events to the system so that they are reminded every day when they check in at work.",
                'image' => "uploads/OurMission/1749718990-section-image-dyc8incl-1png.png",
            ]);
        }
    }
}
