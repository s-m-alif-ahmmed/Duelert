<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('system_settings')->updateOrInsert(
            ['id' => 1],
            [
                'title' => 'Duelert',
                'email' => 'admin@gmail.com',
                'system_name' => 'Duelert',
                'copyright_text' => 'Copyright 2025. All rights reserve Duelert.com',
                'logo' => 'uploads/logo/tmpphpecdvht.png',
                'white_logo' => 'uploads/logo/white_logo.png',
                'favicon' => 'uploads/favicon/tmpphp0a5yxx.png',
                'description' => '<p>Without your customers, there will no need for you to run your business. With Duelert, you will never have to miss their important days anymore. Show your customers you care...</p>',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]
        );
    }
}
