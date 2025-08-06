<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Plan::where('type', 'free')->exists()) {
            Plan::insert([
                [
                    'title' => 'Unleash the power of automation.',
                    'type' => 'starter',
                    'currency' => 'ZAR',
                    'price' => 19.00,
                    'customers_limit' => 50,
                    'storage_limit' => 5,
                    'sms_limit' => 800,
                    'plan_code' => null,
                    'customize_birth_message' => 'Customize Birthday Message',
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }

        if (!Plan::where('type', 'starter')->exists()) {
            Plan::insert([
                [
                    'title' => 'Unleash the power of automation.',
                    'type' => 'starter',
                    'currency' => 'NGN',
                    'price' => 19.00,
                    'customers_limit' => 50,
                    'storage_limit' => 5,
                    'sms_limit' => 800,
                    'plan_code' => null,
                    'customize_birth_message' => 'Customize Birthday Message',
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }

        if (!Plan::where('type', 'professional')->exists()) {
            Plan::insert([
                [
                    'title' => 'Advanced tools to take your work to the next level.',
                    'type' => 'professional',
                    'currency' => 'NGN',
                    'price' => 54.00,
                    'sms_limit' => 2000,
                    'plan_code' => null,
                    'customize_birth_message' => 'Customize Birthday Message',
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }

        if (!Plan::where('type', 'company')->exists()) {
            Plan::insert([
                [
                    'title' => 'Automation plus enterprise-grade features.',
                    'type' => 'company',
                    'currency' => 'NGN',
                    'price' => 89.00,
                    'sms_limit' => 20000,
                    'plan_code' => null,
                    'customize_birth_message' => 'Customize Birthday Message',
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
}
