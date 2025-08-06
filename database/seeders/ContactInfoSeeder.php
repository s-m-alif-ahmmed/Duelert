<?php

namespace Database\Seeders;

use App\Models\ContactInfo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // if (!\App\Models\ContactInfo::exists()) {
        //     \App\Models\ContactInfo::create([
        //         'title' => null,
        //         'subtitle' => null,
        //         'phone' => null,
        //         'email' => null,
        //         'image' => null,
        //         'created_at' => now(),
        //     ]);
        // }
        DB::table('contact_infos')->updateOrInsert(
            ['id' => 1],
            [
                'title' => 'Contact Information',
                'subtitle' => 'Fill up the form and our Team will get back to you within 24 hours.',
                'phone' => '+1 (859) 262-9576',
                'email' => 'vacaqavar@mailinator.com',
                'image' => 'uploads/ContactInfo/1749709554-smilingpng.png',
                'created_at' => Carbon::create('2025', '06', '12', '06', '08', '25'),
                'updated_at' => Carbon::create('2025', '06', '12', '06', '25', '54'),
            ]
        );
    }
}
