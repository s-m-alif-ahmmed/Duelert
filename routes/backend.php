<?php

use App\Http\Controllers\Web\Backend\AdminController;
use App\Http\Controllers\Web\Backend\BlogController;
use App\Http\Controllers\Web\Backend\CmsController;
use App\Http\Controllers\Web\Backend\ContactInfoController;
use App\Http\Controllers\Web\Backend\DynamicPageController;
use App\Http\Controllers\Web\Backend\FaqController;
use App\Http\Controllers\Web\Backend\FeelTopOnTheWorldController;
use App\Http\Controllers\Web\Backend\OurKeyHighlightController;
use App\Http\Controllers\Web\Backend\OurMissionController;
use App\Http\Controllers\Web\Backend\PackageInfoController;
use App\Http\Controllers\Web\Backend\PersonalReminderController;
use App\Http\Controllers\Web\Backend\PlanController;
use App\Http\Controllers\Web\Backend\Settings\MailSettingController;
use App\Http\Controllers\Web\Backend\Settings\ProfileController;
use App\Http\Controllers\Web\Backend\Settings\StripeSettingController;
use App\Http\Controllers\Web\Backend\Settings\SystemSettingController;
use App\Http\Controllers\Web\Backend\Settings\TwillioController;
use App\Http\Controllers\Web\Backend\SocialMediaController;
use App\Http\Controllers\Web\Backend\TemplateController;
use App\Http\Controllers\Web\Backend\UserController;
use App\Http\Controllers\Web\Backend\ValueWeOfferController;
use App\Http\Controllers\Web\Backend\WhychooseUsController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;










Route::middleware([AdminMiddleware::class])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    //! Route for System Settings
    Route::controller(SystemSettingController::class)->group(function () {
        Route::get('/system-setting', 'index')->name('system.index');
        Route::patch('/system-setting', 'update')->name('system.update');
    });

    //! Route for Mail Settings
    Route::controller(MailSettingController::class)->group(function () {
        Route::get('/mail-setting', 'index')->name('mail.setting');
        Route::patch('/mail-setting', 'update')->name('mail.update');
    });

    //! Route for Stripe Settings
    Route::controller(StripeSettingController::class)->group(function () {
        Route::get('/stripe-setting', 'index')->name('stripe.index');
        Route::get('/google-setting', 'google')->name('google.index');
        Route::patch('/credentials-setting', 'update')->name('credentials.update');
    });

    //! Route for Twillio Settings
    Route::controller(TwillioController::class)->group(function () {
        Route::get('/twillio-setting', 'index')->name('twillio.index');
        Route::patch('/twillio-setting/update', 'update')->name('twillio.update');
    });

    //route for Banner
    Route::controller(CmsController::class)->group(function () {
        //Home Banner
        Route::get('/banner/home/edit', 'HomeBannerEdit')->name('home.banner.edit');
        Route::post('/banner/home/update', 'updateHomeBanner')->name('home.banner.update');

        //About Banner
        Route::get('/banner/about/edit', 'aboutBannerEdit')->name('about.banner.edit');
        Route::post('/banner/about/update', 'aboutBannerUpdate')->name('about.banner.update');

        //Blog Banner
        Route::get('/banner/blog/edit', 'blogBannerEdit')->name('blog.banner.edit');
        Route::post('/banner/blog/update', 'blogBannerUpdate')->name('blog.banner.update');

        //Blog Details Banner
        Route::get('/banner/blog/details/edit', 'blogDetailsBannerEdit')->name('blog.details.edit');
        Route::post('/banner/blog/details/update', 'blogDetailsBannerUpdate')->name('blog.details.update');

        //Contact Banner
        Route::get('/banner/contact/edit', 'contactBannerEdit')->name('contact.banner.edit');
        Route::post('/banner/contact/update', 'contactBannerUpdate')->name('contact.banner.update');

        //Login Banner
        Route::get('/banner/login/edit', 'loginBannerEdit')->name('login.banner.edit');
        Route::post('/banner/login/update', 'loginBannerUpdate')->name('login.banner.update');

        //Login Banner
        Route::get('/banner/signup/edit', 'signupBannerEdit')->name('signup.banner.edit');
        Route::post('/banner/signup/update', 'signupBannerUpdate')->name('signup.banner.update');
    });

    //route for Dynamic page
    Route::controller(DynamicPageController::class)->group(function () {
        Route::get('/dynamic', 'index')->name('dynamic.index');
        Route::get('/dynamic/edit/{id}', 'edit')->name('dynamic.edit');
        Route::post('/dynamic/update/{id}', 'update')->name('dynamic.update');
        Route::get('/dynamic/status/{id}', 'status')->name('dynamic.status');
    });


    //! Route for Profile Settings
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.setting');
        Route::patch('/update-profile', 'UpdateProfile')->name('update.profile');
        Route::put('/update-profile-password', 'UpdatePassword')->name('update.Password');
        Route::post('/update-profile-picture', 'UpdateProfilePicture')->name('update.profile.picture');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'index')->name('user.index');
        Route::get('/user/status/{id}', 'status')->name('user.status');
        Route::delete('/user/destroy/{id}', 'destroy')->name('user.destroy');
    });

    //! Route for FAQ
    Route::controller(FaqController::class)->group(function () {
        Route::get('/faq', 'index')->name('faq.index');
        Route::get('/faq/create', 'create')->name('faq.create');
        Route::post('/faq/store', 'store')->name('faq.store');
        Route::get('/faq/edit/{id}', 'edit')->name('faq.edit');
        Route::patch('/faq/update/{id}', 'update')->name('faq.update');
        Route::get('/faq/status/{id}', 'status')->name('faq.status');
        Route::delete('/faq/destroy/{id}', 'destroy')->name('faq.destroy');
    });


    // why choose us
    Route::controller(WhychooseUsController::class)->group(function () {
        Route::get('/why-choose-us', 'index')->name('why-choose-us.index');
        Route::get('/why-choose-us/create', 'create')->name('why-choose-us.create');
        Route::post('/why-choose-us/store', 'store')->name('why-choose-us.store');
        Route::get('/why-choose-us/status/{id}', 'status')->name('why-choose-us.status');
        //update route
        Route::get('/why-choose-us/edit/{id}', 'edit')->name('why-choose-us.edit');
        Route::put('/why-choose-us/update/{id}', 'update')->name('why-choose-us.update');
        //del route
        Route::delete('/why-choose-us/{id}', 'destroy')->name('why-choose-us.destroy');
    });

    //Our Key Highlight
    Route::controller(OurKeyHighlightController::class)->group(function () {
        Route::get('/key-highlight', 'index')->name('key-highlight.index');
        Route::get('/key-highlight/create', 'create')->name('key-highlight.create');
        Route::post('/key-highlight/store', 'store')->name('key-highlight.store');
        Route::get('/key-highlight/status/{id}', 'status')->name('key-highlight.status');
        Route::get('/key-highlight/edit/{id}', 'edit')->name('key-highlight.edit');
        Route::put('/key-highlight/update/{id}', 'update')->name('key-highlight.update');
        Route::delete('/key-highlight/{id}', 'destroy')->name('key-highlight.destroy');
    });

    //Personal Reminder
    Route::controller(PersonalReminderController::class)->group(function () {
        Route::get('/personal/reminder/edit', 'personalreminderEdit')->name('personal.reminder.edit');
        Route::post('/personal/reminder/update', 'personalreminderUpdate')->name('personal.reminder.update');
    });

    //Feel Top On The World
    Route::controller(FeelTopOnTheWorldController::class)->group(function () {
        Route::get('/feel/top/the/world/edit', 'feelEdit')->name('feel.top.edit');
        Route::post('/feel/top/the/world/update', 'feelUpdate')->name('feel.top.update');
    });

    //Value We Offer
    Route::controller(ValueWeOfferController::class)->group(function () {
        Route::get('/value/we/offer/edit', 'valueEdit')->name('value.edit');
        Route::post('/value/we/offer/update', 'valueUpdate')->name('value.update');
    });

    //Our Mission
    Route::controller(OurMissionController::class)->group(function () {
        Route::get('/our/mission/edit', 'missionEdit')->name('mission.edit');
        Route::post('/our/mission/update', 'missionUpdate')->name('mission.update');
    });

    //Contact Information
    Route::controller(ContactInfoController::class)->group(function () {
        Route::get('/contact/info/edit', 'contactEdit')->name('contact.edit');
        Route::post('/contact/info/update', 'contactUpdate')->name('contact.update');
    });



    // Social Media Module
    Route::controller(SocialMediaController::class)->group(function () {
        Route::get('/social-media', 'index')->name('social.media');
        Route::get('/social-media/create', 'create')->name('social-media.create');
        Route::post('/social-media/store', 'store')->name('social.media.store');
        Route::put('/social-media/{id}', 'update')->name('social.media.update');
        Route::delete('/social-media/{id}', 'destroy')->name('social.media.destroy');
    });


    //! Route for Blog
    Route::controller(BlogController::class)->group(function () {
        Route::get('/blog', 'index')->name('blog.index');
        Route::get('/blog/create', 'create')->name('blog.create');
        Route::post('/blog/store', 'store')->name('blog.store');
        Route::get('/blog/edit/{id}', 'edit')->name('blog.edit');
        Route::patch('/blog/update/{id}', 'update')->name('blog.update');
        Route::get('/blog/show/{id}', 'show')->name('blog.show');
        Route::get('/blog/status/{id}', 'status')->name('blog.status');
        Route::delete('/blog/destroy/{id}', 'destroy')->name('blog.destroy');
    });

    //! Route for Plan
    Route::controller(PlanController::class)->group(function () {
        Route::get('/plan', 'index')->name('plan.index');
        Route::get('/plan/edit/{id}', 'edit')->name('plan.edit');
        Route::patch('/plan/update/{id}', 'update')->name('plan.update');
        Route::get('/plan/show/{id}', 'show')->name('plan.show');
        Route::get('/plan/status/{id}', 'status')->name('plan.status');
        Route::delete('/plan/destroy/{id}', 'destroy')->name('plan.destroy');
    });


    //! Route for Package Info
    Route::controller(PackageInfoController::class)->group(function () {
        Route::get('/package-info', 'index')->name('package.index');
        Route::get('/package-info/show/{id}', 'show')->name('package.show');
        Route::post('/package-info/status/{id}', 'status')->name('package.status');
    });

    //! Route for Reminder Message Template
    Route::controller(TemplateController::class)->group(function () {
        Route::get('/template', 'index')->name('template.index');
        Route::get('/template/create', 'create')->name('template.create');
        Route::post('/template/store', 'store')->name('template.store');
        Route::get('/template/edit/{id}', 'edit')->name('template.edit');
        Route::patch('/template/update/{id}', 'update')->name('template.update');
        Route::get('/template/show/{id}', 'show')->name('template.show');
        Route::get('/template/status/{id}', 'status')->name('template.status');
        Route::delete('/template/destroy/{id}', 'destroy')->name('template.destroy');
    });

});
