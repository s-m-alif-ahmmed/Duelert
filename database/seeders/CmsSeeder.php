<?php

namespace Database\Seeders;

use App\Models\CMS;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $now = Carbon::now();

        DB::table('c_m_s')->updateOrInsert(['id' => 1], [
            'home_banner_title' => 'Never miss your customers’ birthdays or important reminders!',
            'home_banner_subtitle' => 'Your one stop tool to set reminders and never miss an important date, event or task.',
            'button_text' => 'Schedule Now',
            'home_banner' => 'uploads/Banner/1749716400-blogpng.png',
            'home_banner_two' => 'images/home/banner2.jpg',
            'home_banner_three' => 'images/home/banner3.jpg',
            'home_banner_four' => 'images/home/banner4.jpg',
            'home_banner_five' => 'images/home/banner5.jpg',
            'about_page_title' => null,
            'about_page_banner' => null,
            'blog_page_title' => null,
            'blog_page_banner' => null,
            'blog_details_title' => null,
            'blog_details_banner' => null,
            'contact_page_title' => null,
            'contact_page_banner' => null,
            'login_banner' => null,
            'signup_banner' => null,
            'created_at' => '2025-06-12 06:08:25',
            'updated_at' => '2025-06-12 08:20:00',
        ]);

        DB::table('c_m_s')->updateOrInsert(['id' => 2], [
            'about_page_title' => 'Who We Are',
            'about_page_banner' => 'uploads/Banner/1749790775-blog-heropng.png',
            'created_at' => '2025-06-12 06:08:25',
            'updated_at' => '2025-06-12 06:08:25',
        ]);

        DB::table('c_m_s')->updateOrInsert(['id' => 3], [
            'blog_page_title' => 'Blog post',
            'blog_page_banner' => 'uploads/Banner/1749716284-blog-heropng.png',
            'created_at' => '2025-06-12 06:08:25',
            'updated_at' => '2025-06-12 08:18:04',
        ]);

        DB::table('c_m_s')->updateOrInsert(['id' => 4], [
            'blog_details_title' => 'Blog details',
            'blog_details_banner' => 'uploads/Banner/1749716298-blog-details-bannerpng.png',
            'created_at' => '2025-06-12 06:08:25',
            'updated_at' => '2025-06-12 08:18:18',
        ]);

        DB::table('c_m_s')->updateOrInsert(['id' => 5], [
            'contact_page_title' => 'Contact Us',
            'contact_page_banner' => 'uploads/Banner/1749715470-contact-bannerpng.png',
            'created_at' => '2025-06-12 06:08:25',
            'updated_at' => '2025-06-12 08:04:30',
        ]);

        DB::table('c_m_s')->updateOrInsert(['id' => 6], [
            'home_banner' => 'images/auth/login-banner.jpg',
            'created_at' => '2025-06-12 06:08:25',
            'updated_at' => '2025-06-12 06:08:25',
        ]);

        DB::table('c_m_s')->updateOrInsert(['id' => 7], [
            'home_banner' => 'images/auth/signup-banner.jpg',
            'created_at' => '2025-06-12 06:08:25',
            'updated_at' => '2025-06-12 06:08:25',
        ]);


        // $data = [

        //     // Home page
        //     [
        //         'id' => 1,
        //         'home_banner_title' => "Never miss your customers’ birthdays or important reminders!",
        //         'home_banner_subtitle' => "Your one stop tool to set reminders and never miss an important date, event or task.",
        //         'button_text' => "Schedule Now",
        //         'home_banner' => 'images/home/banner1.jpg',
        //         'home_banner_two' => 'images/home/banner2.jpg',
        //         'home_banner_three' => 'images/home/banner3.jpg',
        //         'home_banner_four' => 'images/home/banner4.jpg',
        //         'home_banner_five' => 'images/home/banner5.jpg',
        //         'about_page_title' => null,
        //         'about_page_banner' => null,
        //         'blog_page_title' => null,
        //         'blog_page_banner' => null,
        //         'blog_details_title' => null,
        //         'blog_details_banner' => null,
        //         'contact_page_title' => null,
        //         'contact_page_banner' => null,
        //     ],
        //     // About page
        //     [
        //         'id' => 2,
        //         'home_banner_title' => null,
        //         'home_banner_subtitle' => null,
        //         'button_text' => null,
        //         'home_banner' => null,
        //         'home_banner_two' => null,
        //         'home_banner_three' => null,
        //         'home_banner_four' => null,
        //         'home_banner_five' => null,
        //         'about_page_title' => 'Who We Are',
        //         'about_page_banner' => 'images/about/about-banner.jpg',
        //         'blog_page_title' => null,
        //         'blog_page_banner' => null,
        //         'blog_details_title' => null,
        //         'blog_details_banner' => null,
        //         'contact_page_title' => null,
        //         'contact_page_banner' => null,
        //     ],
        //     // Blog page
        //     [
        //         'id' => 3,
        //         'home_banner_title' => null,
        //         'home_banner_subtitle' => null,
        //         'button_text' => null,
        //         'home_banner' => null,
        //         'home_banner_two' => null,
        //         'home_banner_three' => null,
        //         'home_banner_four' => null,
        //         'home_banner_five' => null,
        //         'about_page_title' => null,
        //         'about_page_banner' => null,
        //         'blog_page_title' => 'Latest News & Updates',
        //         'blog_page_banner' => 'images/blog/blog-banner.jpg',
        //         'blog_details_title' => null,
        //         'blog_details_banner' => null,
        //         'contact_page_title' => null,
        //         'contact_page_banner' => null,
        //     ],
        //     // Blog details page
        //     [
        //         'id' => 4,
        //         'home_banner_title' => null,
        //         'home_banner_subtitle' => null,
        //         'button_text' => null,
        //         'home_banner' => null,
        //         'home_banner_two' => null,
        //         'home_banner_three' => null,
        //         'home_banner_four' => null,
        //         'home_banner_five' => null,
        //         'about_page_title' => null,
        //         'about_page_banner' => null,
        //         'blog_page_title' => null,
        //         'blog_page_banner' => null,
        //         'blog_details_title' => 'How to Stay Organized with Smart Tools',
        //         'blog_details_banner' => 'images/blog/details-banner.jpg',
        //         'contact_page_title' => null,
        //         'contact_page_banner' => null,
        //     ],
        //     // Contact page
        //     [
        //         'id' => 5,
        //         'home_banner_title' => null,
        //         'home_banner_subtitle' => null,
        //         'button_text' => null,
        //         'home_banner' => null,
        //         'home_banner_two' => null,
        //         'home_banner_three' => null,
        //         'home_banner_four' => null,
        //         'home_banner_five' => null,
        //         'about_page_title' => null,
        //         'about_page_banner' => null,
        //         'blog_page_title' => null,
        //         'blog_page_banner' => null,
        //         'blog_details_title' => null,
        //         'blog_details_banner' => null,
        //         'contact_page_title' => 'Get in Touch With Us',
        //         'contact_page_banner' => 'images/contact/contact-banner.jpg',
        //     ],
        //     // Login page
        //     [
        //         'id' => 6,
        //         'home_banner_title' => null,
        //         'home_banner_subtitle' => null,
        //         'button_text' => null,
        //         'home_banner' => 'images/auth/login-banner.jpg',
        //         'home_banner_two' => null,
        //         'home_banner_three' => null,
        //         'home_banner_four' => null,
        //         'home_banner_five' => null,
        //         'about_page_title' => null,
        //         'about_page_banner' => null,
        //         'blog_page_title' => null,
        //         'blog_page_banner' => null,
        //         'blog_details_title' => null,
        //         'blog_details_banner' => null,
        //         'contact_page_title' => null,
        //         'contact_page_banner' => null,
        //     ],
        //     // Signup page
        //     [
        //         'id' => 7,
        //         'home_banner_title' => null,
        //         'home_banner_subtitle' => null,
        //         'button_text' => null,
        //         'home_banner' => 'images/auth/signup-banner.jpg',
        //         'home_banner_two' => null,
        //         'home_banner_three' => null,
        //         'home_banner_four' => null,
        //         'home_banner_five' => null,
        //         'about_page_title' => null,
        //         'about_page_banner' => null,
        //         'blog_page_title' => null,
        //         'blog_page_banner' => null,
        //         'blog_details_title' => null,
        //         'blog_details_banner' => null,
        //         'contact_page_title' => null,
        //         'contact_page_banner' => null,
        //     ],
        // ];


        // foreach ($data as $item) {
        //     if (CMS::where('id', $item['id'])->exists()) {
        //         echo "ID {$item['id']} already exists. Skipping...\n"; // Newline Added
        //     } else {
        //         CMS::create($item);
        //         echo "ID {$item['id']} inserted successfully.\n"; // Newline Added
        //     }
        // }
    }
}
