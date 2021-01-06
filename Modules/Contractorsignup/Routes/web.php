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
Route::prefix('contractorsignup')->group(function() {
    Route::get('/', 'ContractorsignupController@index');
});*/
Route::resource('contractorsignup', 'ContractorsignupController');

Route::get('/contractorsignup/signup/{token}', 'ContractorsignupController@signup')->name('contractors.signup');

Route::post('/contractorsignup/save', 'ContractorsignupController@save')->name('contractors.save');