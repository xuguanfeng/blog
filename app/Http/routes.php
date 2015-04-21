<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'WelcomeController@index');
Route::get('/jo', function()
{
    return 'Hello Jo';
});

Route::get('user/{id}', function($id)
{
    return 'User Id '.$id;
})->where('id','[0-9]+');

Route::get('user/{name?}', function($name = 'null')
{
    return 'User Name '.$name;
})->where('name','[a-zA-Z]*');

//Route::get('home', 'HomeController@index');
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

//Route::get('auth/login', 'Auth\AuthController@getLogin');
//Route::post('auth/login', 'Auth\AuthController@postLogin');
//Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::group(["prefix"=>"admin","namespace"=>"Admin","middleware"=>"auth"],function(){
    Route::get('/','AdminHomeController@index');
    Route::resource('pages', 'PagesController');
//    Route::get('/pages/create','PagesController@create');
//    Route::get('/pages/{id}/edit','PagesController@edit');
//    Route::post('/pages','PagesController@store');
//    Route::post('/pages/{id}','PagesController@update');
//    Route::delete('/pages/{id}','PagesController@destroy');

});

//blog的Restful页面
Route::resource('/pages', 'HomeController');
//发表回复
Route::POST('/pages/postComment', 'HomeController@postComment');
//删除回复
Route::GET('/pages/deleteComment/{commentId}', 'HomeController@deleteComment');


/**
 * 猜数字的页面迁移
 */
Route::GET('/guess/', 'GuessController@init');
Route::GET('/guess/singleplay/', 'GuessController@init');