<?php

use App\Http\Controllers\API\Authentication\AuthController;
use App\Http\Controllers\API\CMS\CmsController;
use App\Http\Controllers\API\Contacts\ContactsController;
use App\Http\Controllers\API\ContactToAdmin\ContactController;
use App\Http\Controllers\API\Logo\LogoController;
use App\Http\Controllers\API\ourNumber\OurNumberController;
use App\Http\Controllers\API\Payment\PaymentController;
use App\Http\Controllers\API\Reminder\ReminderController;
use App\Http\Controllers\API\Review\ReviewController;
use App\Http\Controllers\API\SocialLogin\SocialLoginController;
use App\Http\Controllers\API\SubscriptionController;
use App\Http\Controllers\API\Templates\TemplateController;
use App\Http\Controllers\API\UserDashboardCalender\CalenderController;
use App\Http\Controllers\API\Plans\PlanController;
use Illuminate\Support\Facades\Route;



Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    // Route::get('all/users', 'index');
    Route::post('/password/forgot', 'forgotPassword');
    Route::post('/password/reset', 'resetPassword');
    Route::post('/password/verify-otp', 'verifyOtp');
    Route::post('/password/resend-otp', 'resendOtp');
    //Continue with google and facebook login
    Route::post('/social/login', [SocialLoginController::class, 'SocialLogin']);
});

//aLL banner list
Route::controller(CmsController::class)->group(function () {
    Route::get('/banner/pages/all', 'index');
    Route::get('/dynamic/pages/all', 'dynamicPage');
    Route::get('/faq/pages/all', 'faq');
    Route::get('/why-choose-us/all', 'whyChooseUs');
    Route::get('/our-key-highlight/all', 'ourKeyHighlight');
    Route::get('/personal/reminder/all', 'personalReminder');
    Route::get('/feel/top/the/world/all', 'feelTopOnTheWorld');
    Route::get('/value/we/offer/all', 'valueWeOffer');
    Route::get('/our-mission/all', 'ourMission');
    Route::get('/contact-info/all', 'contactInfo');
    Route::get('/social/media/all', 'socialMedia');
    //Blog
    Route::get('/blog/all', 'blog');
    Route::get('/blog/details/{id}', 'blogDetails');
});

//Logo list
Route::controller(LogoController::class)->group(function () {
    Route::get('/logo', 'logo');
    Route::get('/coppyright/text', 'coppyrightText');
    Route::get('/aboute/system', 'abouteSystem');
});

//Plans list
Route::controller(PlanController::class)->group(function () {
    Route::get('/plan/all', 'plans');
});

//our numbers
Route::controller(OurNumberController::class)->group(function () {
    Route::get('/our/number/list', 'index');
});

//Review and Rating
Route::controller(ReviewController::class)->group(function () {
    Route::get('/review/get', 'index');
    Route::get('/average/review', 'averageRating');
});




/*
|--------------------------------------------------------------------------
| with jwt middlware api
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::delete('/delete-account', 'deleteAccount');
        Route::post('/profile/update/user', 'ProfileUpdate');
        Route::post('/password/update/user', 'ChangePassword');

        //user profile retrieve
        Route::get('/user/profile/get', 'ProfileGet');
    });

    //! Route for contact form or get in touch
    Route::post('/contact-form', [ContactController::class, 'submitContactForm'])->name('contact-form.submit');

    //! Route for user dashboard calender
    Route::controller(CalenderController::class)->group(function () {
        Route::post('/add-event', 'addEvent')->name('add-event');
        Route::get('/event-list', 'getEvents')->name('event-list');
    });

    //! Route for user dashboard contacts
    Route::controller(ContactsController::class)->group(function () {
        Route::post('/add/contact', 'store');
        Route::post('/update/contact/{id}', 'update');
        Route::get('/contact-list', 'getContacts');
        Route::delete('/delete/contact/{id}', 'destroy');
    });

    //! Route for user dashboard templates
    Route::controller(TemplateController::class)->group(function () {
        Route::get('/template/list', 'templateList');
    });


    //Reminder
    Route::controller(ReminderController::class)->group(function () {
        Route::get('/reminder/pending/list', 'index');
        Route::get('/reminder/successfull/list', 'successReminderList');
        Route::post('/reminder/create', 'createReminder');
        Route::post('/reminder/update/{id}', 'updateReminder');
        Route::delete('/reminders/delete/{id}', 'destroy');
    });

    //Review and Rating
    Route::controller(ReviewController::class)->group(function () {
        Route::post('/review/store', 'store');
    });

    //! Route for buying Plan with monthly subscribe
    Route::controller(PaymentController::class)->group(function () {
        Route::post('/subscribe', 'initializePayment');
    });

    Route::controller(SubscriptionController::class)->group(function () {
        Route::get('billing/cancel', 'cancel')->name('billing.cancel');
        Route::get('billing/restart', 'restart')->name('billing.restart');
        Route::post('billing/process', 'handlePaystackPostCallBack')->name('billing.process.post');
        Route::post('/free-subscription', 'freeSubscription')->name('free.subscription');
    });
});
