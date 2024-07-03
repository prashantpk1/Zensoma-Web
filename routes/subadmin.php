
<?php

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
|
| Here is where you can register student routes for your application.
|
*/

use Illuminate\Support\Facades\Route;

Route::middleware('is_subadmin')->group(function () {

    Route::resource('calendar', 'SubAdmin\CalendarController');

    Route::resource('my-session', 'SubAdmin\MySessionController');
    Route::get('my-session-status/{id}', 'SubAdmin\MySessionController@mySessionStatus')->name('my-session.status');
    Route::get('remove.video1/{id}','SubAdmin\MySessionController@removeVideo')->name('remove.video1');
    
    Route::resource('my-booking', 'SubAdmin\BookingController');
    Route::get('create.session/{id}','SubAdmin\BookingController@createSession')->name('create.session');

    Route::post('lol', 'Admin\CategoriesController@subCategoryList')->name('lol');

    



});
