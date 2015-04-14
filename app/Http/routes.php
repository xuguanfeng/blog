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

//Route::controllers([
//	'auth' => 'Auth\AuthController',
//	'password' => 'Auth\PasswordController',
//]);

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::group(["prefix"=>"admin","namespace"=>"Admin","middleware"=>"auth"],function(){
    Route::get('/','AdminHomeController@index');
    Route::resource('pages', 'PagesController');
//    Route::get('/pages/create','PagesController@create');
//    Route::get('/pages/{id}/edit','PagesController@edit');
//    Route::post('/pages','PagesController@store');
//    Route::post('/pages/{id}','PagesController@update');
//    Route::delete('/pages/{id}','PagesController@destroy');

});

Route::resource('/pages', 'HomeController');