<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['before' => 'guest'], function()
{
	Route::get('login', ['uses' => 'UsersController@getLogin', 'as' => 'login']);
	Route::post('login', ['uses' => 'UsersController@postLogin', 'as' => 'login.post']);

	Route::get('inscription', ['uses' => 'UsersController@getRegister', 'as' => 'register']);
	Route::post('inscription', ['uses' => 'UsersController@postRegister', 'as' => 'register.post']);
});

Route::group(['before' => 'auth'], function()
{
	$id = '[0-9]+';
	Route::get('/', ['uses' => 'UploadsController@index', 'as' => 'upload']);
	Route::get('upload/rename/{upload_id}', ['uses' => 'UploadsController@getRename', 'as' => 'upload.rename'])->where('upload_id', $id);
	Route::post('upload/rename/{upload_id}', ['uses' => 'UploadsController@postRename', 'as' => 'upload.rename.post'])->where('upload_id', $id);

	Route::get('upload/delete/{upload_id}', ['uses' => 'UploadsController@getDelete', 'as' => 'upload.delete'])->where('upload_id', $id);

	Route::get('upload/download/{upload_id}', ['uses' => 'UploadsController@getDownload', 'as' => 'upload.download'])->where('upload_id', $id);

	Route::get('upload/share/{upload_id}', ['uses' => 'UploadsController@getShare', 'as' => 'upload.share'])->where('upload_id', $id);
	Route::post('upload/share/{upload_id}', ['uses' => 'UploadsController@postShare', 'as' => 'upload.share.post'])->where('upload_id', $id);
	Route::get('upload/share/delete/{upload_id}', ['uses' => 'UploadsController@getShareDelete', 'as' => 'upload.share.delete'])->where('upload_id', $id);

	Route::post('upload', ['uses' => 'UploadsController@store', 'as' => 'upload.post']);

	Route::get('contact', ['uses' => 'ContactController@index', 'as' => 'contact']);
	Route::post('contact', ['uses' => 'ContactController@send', 'as' => 'contact.post']);

	Route::get('logout', ['uses' => 'UsersController@getLogout', 'as' => 'logout']);
});

Route::group(['prefix' => 'admin', 'before' => 'admin'], function(){
	$id = '[0-9]+';
	$alphanum = '[a-zA-Z0-9]+';
    Route::get('/', ['uses' => 'Admin\AdminsController@index', 'as' => 'admin']);
    Route::get('users', ['uses' => 'Admin\UsersController@index', 'as' => 'admin.users']);
    Route::get('users/create', ['uses' => 'Admin\UsersController@create', 'as' => 'admin.create_user']);
    Route::post('users/create', ['uses' => 'Admin\UsersController@store', 'as' => 'admin.create_user.post']);
    Route::get('users/edit/{id}', ['uses' => 'Admin\UsersController@edit', 'as' => 'admin.edit_user'])->where('id', $id);
    Route::post('users/edit/{id}', ['uses' => 'Admin\UsersController@update', 'as' => 'admin.edit_user.post'])->where('id', $id);
    Route::get('users/delete/{id}', ['uses' => 'Admin\UsersController@destroy', 'as' => 'admin.destroy_user'])->where('id', $id);

    Route::get('files', ['uses' => 'Admin\UploadsController@index', 'as' => 'admin.files']);
    Route::get('{user_name}', ['uses' => 'Admin\UploadsController@index', 'as' => 'admin.user_name'])->where('user_name', $alphanum);

});