<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faqs')->updateOrInsert(
            ['id' => 1],
            [
                'question' => 'What data sources are used?',
                'answer' => 'The Areainsight platform aggregates and analyzes data from a variety of trusted and authoritative sources to provide comprehensive, up-to-date, and reliable neighborhood insights.',
                'status' => 'active',
                'created_at' => '2025-06-12 09:07:24',
                'updated_at' => '2025-06-12 09:07:24',
            ]
        );

        DB::table('faqs')->updateOrInsert(
            ['id' => 2],
            [
                'question' => 'How current is the data?',
                'answer' => 'The data is regularly updated to ensure that it remains current and reflects the latest neighborhood trends and insights.',
                'status' => 'active',
                'created_at' => '2025-06-12 09:08:04',
                'updated_at' => '2025-06-12 09:08:04',
            ]
        );
    }
}
