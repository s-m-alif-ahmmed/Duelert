<?php

namespace Database\Seeders;

use App\Models\PersonalReminderCompanion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalReminderCompanionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'id' => 1,
            'title' => 'Never Forget Again: Your Personal Reminder Companion',
            'image' => 'uploads/PersonalReminder/1749786344-calender-ccczvgwwpng.png',
            'description' => 'Introducing our revolutionary reminder website, your ultimate tool for staying organized and on top of your commitments. With intuitive features and customizable alerts, never miss an important date or task again. From appointments to deadlines, streamline your life effortlessly with our user-friendly platform. Try it now and experience efficiency redefined.',
            'status' => 'active',
            'created_at' => '2025-06-12 10:14:09',
            'updated_at' => '2025-06-13 09:46:07',
        ];

        PersonalReminderCompanion::firstOrCreate(['id' => $data['id']], $data);
    }
}
