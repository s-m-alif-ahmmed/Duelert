<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([UserSeeder::class]);
        $this->call([DynamicPageSeeder::class]);
        $this->call([CmsSeeder::class]);
        // $this->call([PersonalReminderSeeder::class]);
        $this->call([FeelTopOnTheWorld::class]);
        $this->call([ValueWeOfferSeeder::class]);
        $this->call([OurMissionSeeder::class]);
        $this->call([ContactInfoSeeder::class]);
        $this->call([PlanSeeder::class]);
        $this->call([TemplateSeeder::class]);
        $this->call([FaqSeeder::class]);
        $this->call([FeelTopOnTheWorldSeeder::class]);
        $this->call([OurKeyHighlightsSeeder::class]);
        $this->call([PersonalReminderCompanionSeeder::class]);
        $this->call([WhyChooseUsSeeder::class]);
        $this->call([BlogSeeder::class]);
        $this->call([SystemSettingsSeeder::class]);
    }
}
