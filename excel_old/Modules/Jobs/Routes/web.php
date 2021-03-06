<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::prefix('jobs')->group(function() {
    Route::get('/', 'JobsController@index');
});
*/

Route::resource('jobs', 'JobsController');

Route::get('calendar', 'JobsController@calendar')->name('jobs.calendar');

Route::get('signcontract', 'JobsController@signcontract')->name('sign.contract');