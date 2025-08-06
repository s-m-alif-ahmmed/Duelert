<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminExists = \App\Models\User::where('id', 1)->exists();
        $userExists = \App\Models\User::where('id', 2)->exists();

        if (!$adminExists) {
            \App\Models\User::create([
                'id' => 1,
                'name' => 'Mr. Admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
            ]);
        }

        if (!$userExists) {
            \App\Models\User::create([
                'id' => 2,
                'name' => 'Mr. User',
                'email' => 'user@gmail.com',
                'role' => 'user',
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
            ]);
        }

        if ($adminExists && $userExists) {
            $this->command->info('User already exist.');
        }
    }
}
