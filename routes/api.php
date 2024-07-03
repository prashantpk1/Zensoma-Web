<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\CMSController;
use App\Http\Controllers\API\V1\BlogController;
use App\Http\Controllers\API\V1\BuddyController;
use App\Http\Controllers\API\V1\ThemeController;
use App\Http\Controllers\API\V1\AccountController;
use App\Http\Controllers\API\V1\SessionController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\SubAdminController;
use App\Http\Controllers\API\V1\SleepUserController;
use App\Http\Controllers\API\V1\TherapistController;
use App\Http\Controllers\Cron\WalkReminderController;
use App\Http\Controllers\API\V1\FrinedListsController;
use App\Http\Controllers\Cron\SleepReminderController;
use App\Http\Controllers\API\V1\NotificationController;
use App\Http\Controllers\API\V1\SubscriptionController;
use App\Http\Controllers\API\V1\MultiLanguageController;
use App\Http\Controllers\API\V1\ChallengeFriendController;
use App\Http\Controllers\Cron\DrinkWaterReminderController;
use App\Http\Controllers\API\V1\MyFavoriteSessionController;
use App\Http\Controllers\API\V1\PredefinedQuestionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login',[AccountController::class, 'login']);
Route::post('/register',[AccountController::class, 'register']);
Route::post('/social-register',[AccountController::class, 'socialRegister']);
Route::post('/forgot-password',[AccountController::class, 'forgotPassword']);
Route::post('/verify-otp', [AccountController::class, 'verifyOTP']);
Route::post('/reset-password', [AccountController::class, 'resetPassword']);

//master api
    Route::get('/get-themes',[ThemeController::class, 'getThemes']);
    Route::get('/get-categories',[CategoryController::class, 'getCategories']);
    Route::get('get-sub-categories/{id}',[CategoryController::class, 'getSubCategories']);
    Route::get('/get-languages',[CategoryController::class, 'getLanguages']);
    Route::get('/get-countrys',[CategoryController::class, 'getCountrys']);
    Route::get('/random-quote',[CategoryController::class, 'randomQuote']);
    Route::get('/get-categories-subcategories-types',[CategoryController::class, 'getCategoriesSubcategoriesTypes']);

    //get app label and content
    Route::get('/get-all-labels',[MultiLanguageController::class, 'getAllLabels']);

  //blog
  Route::post('/get-blogs',[BlogController::class, 'getBlogs']);
  Route::post('get-blog',[BlogController::class, 'getBlog']);

  //predifined question
  Route::post('get-predefined-questions',[PredefinedQuestionController::class, 'getPredefinedQuestions']);

  //cms
  Route::post('get-cms-content',[CMSController::class, 'getCms']);

  //session
  Route::post('sessions_new',[SessionController::class, 'sessions_new']);
  Route::post('sessions',[SessionController::class, 'sessions']);
  Route::post('session-detail',[SessionController::class, 'sessionDetail']);

  //   serach work  list
  Route::post('serach-word',[CategoryController::class, 'serachWord']);
  Route::get('send-notification',[CategoryController::class, 'sendNotification']);

  Route::post('dashboard',[AccountController::class, 'dashboard']);


   
 
   

// middlewere start
//   =====================================================================================================
Route::middleware('auth:api')->group(function () {


      //account api
   Route::get('dashboard_bk',[AccountController::class, 'dashboard_bk']);
   Route::get('delete-account',[AccountController::class, 'deleteAccount']);

    //account api
    Route::get('profile',[AccountController::class, 'profile']);
    Route::post('edit-profile',[AccountController::class, 'editProfile']);
    Route::post('change-password',[AccountController::class, 'changePassword']);
    Route::post('logout',[AccountController::class, 'logout']);

    //sub admin or theripist api
    Route::post('/get-therapists',[SubAdminController::class, 'getTherapists']);
    Route::get('get-therapist-detail/{id}',[SubAdminController::class, 'getTherapistDetail']);

    //subscription
    Route::get('/get-subscriptions',[SubscriptionController::class, 'getSubscriptions']);
    Route::post('buy-or-update-user-subscription',[SubscriptionController::class, 'buyOrUpdateUserSubscription']);

    //add session to favirite
    Route::post('add-or-remove-favorite',[MyFavoriteSessionController::class, 'addOrRemoveFavorite']);

    // check tharopist availble slot
    Route::post('available-slot',[TherapistController::class, 'availableSlot']);

    // Route::get('friend-list',[FrinedListsController::class, 'friendList']);
    // Route::post('add-friend',[FrinedListsController::class, 'addFriend']);
    // Route::post('remove-friend',[FrinedListsController::class, 'removeFriend']);


    //buddy api
    Route::post('buddy-list',[BuddyController::class, 'buddyList']);
    Route::post('add-buddy',[BuddyController::class, 'addBuddy']);
    Route::post('remove-buddy',[BuddyController::class, 'removeBuddy']);

    //my session
    Route::post('add-update-session-my-session',[SessionController::class, 'addUpdateSessionToMySession']);
    Route::post('my-session',[SessionController::class, 'mySessions']);

    //mu favorite session api
    Route::post('my-favorite-session',[MyFavoriteSessionController::class, 'myFavoriteSession']);
    Route::post('get-buddy-session-detail',[BuddyController::class, 'getBuddySessionDetail']);

     //account api
    Route::get('notification',[NotificationController::class, 'notification']);

    //challenge friend
    Route::post('add-challenge-friend',[ChallengeFriendController::class, 'addChallengeFriend']);
    Route::post('my-challenges',[ChallengeFriendController::class, 'myChallenges']);
    Route::post('complate-challenge',[ChallengeFriendController::class, 'complateChallenge']);

    Route::post('predefined-question-answers-save',[PredefinedQuestionController::class, 'predefinedQuestionAnswersSave']);
    Route::post('predefined-question-answers-save-test',[PredefinedQuestionController::class, 'predefinedQuestionAnswersSaveTest']);
    Route::post('theme-save',[ThemeController::class, 'themeSave']);

    //tharepist booking api for slot booking
    Route::post('booking',[TherapistController::class,'booking']);
    Route::post('my-booking',[TherapistController::class,'mybooking']);


     //set data for reminder
    Route::post('drink-water-reminder-save',[DrinkWaterReminderController::class, 'drinkWaterReminderSave']);
    Route::post('walk-reminder-save',[WalkReminderController::class, 'WalkReminderSave']);
    Route::post('sleep-reminder-save',[SleepReminderController::class, 'SleepReminderSave']);

    Route::post('check-contact-register-or-not',[AccountController::class, 'checkContactRegisterOrNot']);
    Route::get('/get-user-gamification-detail',[AccountController::class, 'getUserGamificationDetail']);

    Route::post('user-sleep-log-save',[SleepUserController::class, 'userSleepLogSave']);


});

//   =====================================================================================================
// middlewere end


