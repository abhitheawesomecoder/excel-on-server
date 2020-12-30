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
Route::prefix('clients')->group(function() {
    

    //Route::get('/{id}/edit#', 'ClientsController',['as' => 'clients']);
});*/
Route::resource('clients', 'ClientsController');

Route::resource('stores', 'StoresController');

Route::prefix('clients')->group(function() {


	Route::get('/{id}/stores/create', 'StoresController@create',['as' => 'stores.create']);

	Route::get('/{id}/contacts/create', 'ClientsController@contactcreate',['as' => 'contacts.create']);

	//Route::get('/{id}/stores/create', 'StoresController@create',['as' => 'stores.create']);

	Route::post('/api/getaddress', 'ClientsController@getaddress');

});

Route::prefix('stores')->group(function() {
	Route::get('/{id}/contacts/create', 'StoresController@contactcreate',['as' => 'storecontacts.create']);
});