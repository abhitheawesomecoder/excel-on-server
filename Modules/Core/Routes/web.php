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
     * Comments Extension
     */

    Route::post('extensions/comments/post-comment', ['as'=>'core.ext.comments.post-comment','uses'=>'CommentsController@postComment']);

    Route::get('extensions/comments/get-users', ['as'=>'core.ext.comments.get-uses','uses'=>'CommentsController@getUsers']);

    Route::post('extensions/comments/get-comments', ['as'=>'core.ext.comments.get-comments','uses'=>'CommentsController@getComments']);

    Route::post('extensions/comments/upvote', ['as'=>'core.ext.comments.get-comments','uses'=>'CommentsController@upvoteComment']);

    Route::put('extensions/comments/update-comment', ['as'=>'core.ext.comments.update-comment','uses'=>'CommentsController@updateComment']);

    Route::delete('extensions/comments/delete-comment', ['as'=>'core.ext.comments.update-comment','uses'=>'CommentsController@deleteComment']);

	/**
     * Attachments Extension
     */

    Route::post('extensions/attachments/get-attachments', ['as'=>'core.ext.attachments.get-attachments','uses'=>'AttachmentsController@getAttachments']);

    Route::delete('extensions/attachments/delete-attachment/{entityClass}/{entityId}/{key}', ['as'=>'core.ext.attachments.delete-attachment','uses'=>'AttachmentsController@deleteAttachment']);

    Route::post('extensions/attachments/upload-attachments/', ['as'=>'core.ext.attachments.upload-attachments','uses'=>'AttachmentsController@uploadAttachments']);
