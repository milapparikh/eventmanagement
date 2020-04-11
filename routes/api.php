<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'API\UserController@login');		//users and admin login
Route::post('events', 'API\EventController@eventslists');	//Listing of all events to anyone

Route::group(['middleware' => ['auth:api','adminauth']], function(){
	Route::post('register', 'API\UserController@register');		//Only admin can create users
	Route::post('eventcreate', 'API\EventController@store');
	//Route::post('details', 'API\UserController@details');
});



