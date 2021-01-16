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
Route::prefix('contractorprofile')->group(function() {
    Route::get('/', 'ContractorprofileController@index');
});*/
//Route::resource('jobrequested', 'JobRequestedController');

Route::get('/job/{status}', 'ContractorprofileController@index')->name('job.status');