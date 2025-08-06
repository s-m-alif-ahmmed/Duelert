<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WhyChooseUs;

class WhyChooseUsSeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            [
                'id' => 1,
                'name' => 'Why choose us?',
                'title' => 'The Value we offer',
                'subtitle' => 'Duelert is a calendar tool that alerts businesses of customers\' birthday, vehicle renewal alerts and important schedules. It\'s also a great tool for reminding people of birthdays, anniversaries, appointments and more.',
                'image' => 'uploads/WhyChooseUs/1749786189-download-4png.png',
                'body_title' => 'Anniversaries of any kind',
                'description' => 'Celebrate milestones with us! Whether it\'s a work anniversary, relationship milestone, or any special occasion, mark the moment with our tailored surprises and heartfelt gestures.',
                'status' => 'active',
                'created_at' => '2025-06-13 09:41:42',
                'updated_at' => '2025-06-13 09:43:09',
            ],
            [
                'id' => 2,
                'name' => 'Why choose us?',
                'title' => 'The Value we offer',
                'subtitle' => 'Duelert is a calendar tool that alerts businesses of customers\' birthday, vehicle renewal alerts and important schedules. It\'s also a great tool for reminding people of birthdays, anniversaries, appointments and more.',
                'image' => 'uploads/WhyChooseUs/1749786610-download-5png.png',
                'body_title' => 'Festive Greetings',
                'description' => 'Renew your vehicle hassle-free with us! Enjoy streamlined processes, timely reminders, and expert assistance. Stay on the road smoothly with our efficient renewal services.',
                'status' => 'active',
                'created_at' => '2025-06-13 09:50:10',
                'updated_at' => '2025-06-13 09:50:10',
            ],
            [
                'id' => 3,
                'name' => 'Why choose us?',
                'title' => 'The Value we offer',
                'subtitle' => 'Customer’s Birthdays Celebrate with us! Enjoy exclusive discounts and personalized offers on your special day. Join our birthday club for VIP treatment and unforgettable surprises.',
                'image' => 'uploads/WhyChooseUs/1749786686-download-6png.png',
                'body_title' => 'Customer’s Birthdays',
                'description' => 'Celebrate with us! Enjoy exclusive discounts and personalized offers on your special day. Join our birthday club for VIP treatment and unforgettable surprises.',
                'status' => 'active',
                'created_at' => '2025-06-13 09:51:26',
                'updated_at' => '2025-06-13 09:51:26',
            ],
        ];

        foreach ($records as $record) {
            WhyChooseUs::firstOrCreate(['id' => $record['id']], $record);
        }
    }
}
