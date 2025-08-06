<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'type' => 'birthday',
                'message' => 'Happy birthday! Wishing you a day filled with love, laughter and all your favorite things.',
            ],
            [
                'type' => 'anniversary',
                'message' => 'Happy anniversary! Wishing you a day filled with love, laughter and all your favorite memories.',
            ],
            [
                'type' => 'festive',
                'message' => 'Happy festive season! Wishing you a holiday season filled with joy, love and all your favorite things.',
            ],
            [
                'type' => 'thank_you',
                'message' => 'Thank you for your business! We appreciate your trust and look forward to serving you again in the future.',
            ],
            [
                'type' => 'congratulations',
                'message' => 'Congratulations! Wishing you all the best on your future endeavors.',
            ],
            [
                'type' => 'reminders',
                'message' => 'Don\'t forget! You have an upcoming appointment on [date].',
            ],
            [
                'type' => 'invitations',
                'message' => 'You\'re invited! Join us for our upcoming event on [date].',
            ],
            [
                'type' => 'professional',
                'message' => 'Thank you for considering us for your [service]. We look forward to working with you.',
            ],
            [
                'type' => 'welcome',
                'message' => 'Welcome! We\'re thrilled to have you on board and look forward to serving you.',
            ],
        ];

        foreach ($templates as $template) {
            $existing = \App\Models\Template::where('type', $template['type'])
                ->where('message', $template['message'])
                ->first();

            if (!$existing) {
                \App\Models\Template::create($template);
            } else {
                $this->command->info("Template for type {$template['type']} already exists.");
            }
        }
    }
}
