<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ZoomControllerNew;
use App\Http\Controllers\Admin\ZoomController;
use App\Http\Controllers\Cron\SubscriptionController;
use App\Http\Controllers\Cron\WalkReminderController;
use App\Http\Controllers\Admin\ZoomVideoSDKController;
use App\Http\Controllers\Cron\SleepReminderController;
use App\Http\Controllers\Cron\DrinkWaterReminderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('/create-session', [ZoomControllerNew::class, 'createSession'])->name('create-session');

//cron
Route::get('/sleep-reminder-start_at-and-end_at', [SleepReminderController::class, 'sleepReminderStartAtAndEndAt'])->name('sleep-reminder-start_at-and-end_at');
Route::get('/send-walk-reminders-day-at', [WalkReminderController::class, 'sendWalkRemindersDayAt'])->name('send-walk-reminders-day-at');
Route::get('/send-water-reminders-day-at', [DrinkWaterReminderController::class, 'sendWaterRemindersDayAt'])->name('send-water-reminders-day-at');
Route::get('/send-water-reminders-hours', [DrinkWaterReminderController::class, 'sendWaterReminders'])->name('send-water-reminders-hours');
Route::get('/subscription-expired', [SubscriptionController::class, 'subscriptionExpired'])->name('subscription-expired');
Route::get('/add-entry-user-detail', [SubscriptionController::class, 'addEntryUserDetail'])->name('add-entry-user-detail');



Route::get('page-404', [ProfileController::class, 'page404'])->name('page-404');
Route::get('do-have-permission', [ProfileController::class, 'doHavePermission'])->name('do-have-permission');

Route::get('forgot-passwords', [ProfileController::class, 'getForgotPassword'])->name('forgot-passwords');
Route::post('forgot-passwords1', [ProfileController::class, 'ForgotPassword'])->name('forgot-passwords1');
Route::get('verify_otp/{id}',[ProfileController::class, 'verifyOtp'])->name('verify_otp');
Route::post('verify_otp_check', [ProfileController::class, 'verifyOtpCheck'])->name('verify_otp_check');
Route::get('reset.password/{id}',[ProfileController::class,'resetPassword'])->name('reset.password');
Route::post('reset.passwords',[ProfileController::class,'resetPasswords'])->name('reset.passwords');





Route::middleware('auth')->group(function () {
Route::get('/setting', [ProfileController::class, 'setting'])->name('setting');
});


Route::get('join_meeting/{id}', 'SubAdmin\BookingController@joinMeeting')->name('join_meeting');

Route::get('create-zoom-session', [ZoomController::class, 'generateToken']);

Route::post('/sub.category.list', 'Admin\CategoriesController@subCategoryList')->name('sub.category.list');

Route::post('/get.type', 'Admin\CategoryTypeController@getType')->name('get.type');

Route::post('/sub-category-list-list', 'Admin\CategoriesController@subCategoryList')->name('sub.category.list.list');


// Route::get('create-zoom-meeting', [ZoomController::class, 'create']);
// Route::get('start', [ZoomController::class, 'index']);
// Route::any('zoom-meeting-create', [ZoomController::class, 'index'])->name('zoom-meeting-create');
// Route::get('join_meeting', [ZoomController::class, 'join_meeting'])->name('join_meeting');

Route::middleware('is_admin')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/getChangePassword', [ProfileController::class, 'storeChangePassword'])->name('store.change.password');

    Route::resource('language', 'Admin\LanguageController');
    Route::get('language-status/{id}', 'Admin\LanguageController@languageStatus')->name('language.status');

    Route::resource('quote', 'Admin\QuoteController');
    Route::get('quote-status/{id}', 'Admin\QuoteController@quoteStatus')->name('quote.status');

    Route::resource('blog', 'Admin\BlogController');
    Route::get('blog-status/{id}', 'Admin\BlogController@blogStatus')->name('blog.status');

    Route::resource('customer', 'Admin\CustomerController');
    Route::get('customer-status/{id}', 'Admin\CustomerController@customerStatus')->name('customer.status');


    Route::resource('category', 'Admin\CategoriesController');
    Route::get('category-status/{id}', 'Admin\CategoriesController@categoryStatus')->name('category.status');


    Route::resource('coupon', 'Admin\CouponController');
    Route::get('coupon-status/{id}', 'Admin\CouponController@couponStatus')->name('coupon.status');

    Route::resource('word', 'Admin\WordlistController');
    Route::get('word-status/{id}', 'Admin\WordlistController@wordStatus')->name('word.status');


    Route::resource('multi-language', 'Admin\MultiLanguageController');
    Route::get('multi-language-status/{id}', 'Admin\MultiLanguageController@multilanguageStatus')->name('multi-language-status');


    Route::resource('content', 'Admin\ContentManagementController');
    Route::get('content-status/{id}', 'Admin\ContentManagementController@contentStatus')->name('content.status');
    Route::get('remove.video/{id}','Admin\ContentManagementController@removeVideo')->name('remove.video');


    Route::resource('subscription', 'Admin\SubscriptionController');
    Route::get('subscription-status/{id}', 'Admin\SubscriptionController@subscriptionStatus')->name('subscription.status');


    Route::resource('subadmin', 'Admin\SubAdminController');
    Route::get('subadmin-status/{id}', 'Admin\SubAdminController@subadminStatus')->name('subadmin.status');


    Route::resource('buddy-network', 'Admin\BuddyNetworkController');

    Route::resource('question', 'Admin\PredefinedQuestionController');
    Route::get('question-status/{id}', 'Admin\PredefinedQuestionController@questionStatus')->name('question.status');

    Route::resource('notification', 'Admin\CustomizedNotificationController');
    Route::get('notification-status/{id}', 'Admin\CustomizedNotificationController@notificationStatus')->name('notification.status');

    Route::resource('cms', 'Admin\CmsController');
    Route::get('cms-status/{id}', 'Admin\CmsController@cmsStatus')->name('cms.status');
    Route::get('get-cms-content/{id}', 'Admin\CmsController@getCmsPageContent')->name('cms.content');

    Route::resource('transaction', 'Admin\TransactionController');
    Route::resource('running-subscription', 'Admin\RunningSubscriptionController');


    Route::resource('advertisement', 'Admin\AdvertisementController');
    Route::get('advertisement-status/{id}', 'Admin\AdvertisementController@advertisementStatus')->name('advertisement.status');

    Route::resource('category-type', 'Admin\CategoryTypeController');
    Route::get('category-type-status/{id}', 'Admin\CategoryTypeController@categoryTypeStatus')->name('category-type.status');

    Route::post('/get-type', 'Admin\CategoryTypeController@getType')->name('get-type');
    

    Route::resource('theme', 'Admin\ThemeController');
    Route::get('theme-status/{id}', 'Admin\ThemeController@themeStatus')->name('theme.status');
    
    Route::resource('level', 'Admin\LevelController');
    Route::get('level-status/{id}', 'Admin\LevelController@levelStatus')->name('level.status');

    Route::resource('badge', 'Admin\BadgeController');
    Route::get('badge-status/{id}', 'Admin\BadgeController@badgeStatus')->name('badge.status');

    Route::resource('tag', 'Admin\TagController');
    Route::get('tag-status/{id}', 'Admin\TagController@tagStatus')->name('tag.status');
    
    Route::resource('gamification-config', 'Admin\GamificationConfigController');
    Route::get('gamification-config-status/{id}', 'Admin\GamificationConfigController@gamificationConfigStatus')->name('gamification-config.status');

    Route::resource('booking', 'Admin\BookingController');

  




});

require __DIR__.'/auth.php';
require __DIR__.'/subadmin.php';
