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
//Route::group(['prefix'=>'signup','as'=>'signup.', 'namespace' => 'Modules\Signup\Http\Controllers'], function()
//{
Route::prefix('signup')->group(function() {
	
    //Route::get('/', 'SignupController@index');
    //Route::post('store', 'SignupController@store');
  //  Route::get('create', 'SignupController@create');

    Route::resource('/', 'SignupController');

    Route::get('/signin/{token}', 'SignupController@signin')->name('signin');

    Route::post('/signin/save', 'SignupController@save')->name('user.save');
  //Route::resource('photos', 'PhotoController');Method Modules\Signup\Http\Controllers\SignupController::create@index does not exist.
// Create Staff - done
// List Create Request - done
// Mail Sent to Staff - done
// Register Staff - done
// List Staff and Other Users - done
// Delete Request users
// set things as per access control
// expire link
// edit user 

});
