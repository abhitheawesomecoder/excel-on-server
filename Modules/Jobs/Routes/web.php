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

Route::resource('jobtypes', 'JobtypeController');

Route::get('jobs/clone/{id}', 'JobsController@clone')->name('jobs.clone');

Route::get('calendar', 'JobsController@calendar')->name('jobs.calendar');

Route::get('signcontract', 'JobsController@signcontract')->name('sign.contract');

Route::post('invoice-received', 'JobsController@invoice_received')->name('invoice.received');

Route::get('user/job/confirmed/signature/{id}', 'JobsController@signature')->name('user.job.signature');

Route::post('user/job/confirmed/signature', 'JobsController@signaturesave')->name('user.signature.save');