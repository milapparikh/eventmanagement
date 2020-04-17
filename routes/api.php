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



Route::group(['middleware' => ['auth:api']], function(){
	Route::post('commentcreate', 'API\CommentController@store');

	//Following are only 
	Route::group(['middleware' => ['adminauth']], function(){
		Route::post('register', 'API\UserController@register');		//Only admin can create users
		//Route::post('details', 'API\UserController@details');

		//Category Crud Operations
		Route::get('categoryEventList/{category_id}/category', 'API\categoryController@categoryEvent');  
		Route::post('categorys', 'API\CategoryController@create');				//For create category
		Route::get('lists/category', 'API\CategoryController@list');			//For fetch all category
		Route::put('categorys/{id}', 'API\CategoryController@update');			//For update all category
		Route::delete('{id}/category', 'API\CategoryController@delete');	//For delete category


		//Event Crud Operations
		Route::post('eventcreate', 'API\EventController@store');	//Create Event
		Route::post('event/{id}', 'API\EventController@update');			//For update all category
		Route::post('delete/{id}/event', 'API\EventController@delete');	//For delete event
	});
});

/*
Route::group(['middleware' => ['auth:api']], function(){
	Route::post('commentcreate', 'API\CommentController@store');
});
*/

