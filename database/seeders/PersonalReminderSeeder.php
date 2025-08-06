<?php

namespace Database\Seeders;

use App\Models\PersonalReminderCompanion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalReminderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!PersonalReminderCompanion::exists()) {
            PersonalReminderCompanion::create([
                'title' => null,
                'image' => null,
                'description' => null,
            ]);
        } else {
            $this->command->info('Personal Reminder Companion already exist');
        }
    }
}
