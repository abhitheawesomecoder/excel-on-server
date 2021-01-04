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

Route::resource('contacts', 'ContactsController');

Route::resource('store-contacts', 'StorecontactsController');

Route::get('/clients/{id}/delete', 'CommonController@clients_destroy');

Route::get('/stores/{id}/delete', 'CommonController@stores_destroy');

Route::get('/contacts/{id}/delete', 'CommonController@contacts_destroy');

Route::get('/store-contacts/{id}/delete', 'CommonController@store_contacts_destroy');

Route::prefix('clients')->group(function() {


	Route::get('/{id}/stores/create', 'StoresController@create')->name('storescreate');

	Route::get('/{id}/contacts/create', 'ClientsController@contactcreate')->name('contactscreate');

	//Route::get('/{id}/view', 'ClientsController@contactview')->name('contactsview');

	//Route::get('/{id}/stores/create', 'StoresController@create',['as' => 'stores.create']);

	Route::post('/api/getaddress', 'ClientsController@getaddress');

});

Route::prefix('stores')->group(function() {
   Route::get('/{id}/contacts/create', 'StoresController@contactcreate')->name('storecontacts.create');

   /*Route::get('/{store_id}/contacts/{contact_id}/edit', 'StoresController@contactedit')->name('storecontacts.edit');*/
});