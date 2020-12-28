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

Route::prefix('core')->group(function() {
    Route::get('/', 'CoreController@index');
});

	/**
     * Attachments Extension
     */

    Route::post('extensions/attachments/get-attachments', ['as'=>'core.ext.attachments.get-attachments','uses'=>'AttachmentsController@getAttachments']);

    Route::delete('extensions/attachments/delete-attachment/{entityClass}/{entityId}/{key}', ['as'=>'core.ext.attachments.delete-attachment','uses'=>'AttachmentsController@deleteAttachment']);

    Route::post('extensions/attachments/upload-attachments/', ['as'=>'core.ext.attachments.upload-attachments','uses'=>'AttachmentsController@uploadAttachments']);
