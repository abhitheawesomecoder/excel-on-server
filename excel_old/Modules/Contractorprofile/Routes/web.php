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

Route::get('/job/detail/{requested}/{id}', 'ContractorprofileController@requested')->name('job.detail');

//Route::get('/job/requested/{id}', 'ContractorprofileController@requested')->name('job.requested');

//Route::get('/job/confirmed/{id}', 'ContractorprofileController@confirmed')->name('job.confirmed');

//Route::get('/job/completed/{id}', 'ContractorprofileController@completed')->name('job.completed');

//Route::get('/job/detail/{requested}/{id}', 'ContractorprofileController@requested')->name('job.detail');

Route::get('/job/confirmed/signature/{id}', 'ContractorprofileController@signature')->name('job.signature');

Route::post('/job/confirmed/signature', 'ContractorprofileController@save')->name('signature.save');

Route::patch('/job/requested/confirmed/{id}', 'ContractorprofileController@requested_confirmed')->name('job.requested.confirmed');