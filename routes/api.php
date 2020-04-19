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
Route::get('events/{id}/details', 'API\EventController@details');	//Listing of all events to anyone

Route::get('{event_id}/comments', 'API\CommentController@comments');	//display all comments to any one

Route::group(['middleware' => ['auth:api']], function(){
	Route::post('commentcreate', 'API\CommentController@store');
	//Route::get('{event_id}/comments', 'API\CommentController@comments');

	Route::post('events/search', 'API\EventController@search');	//Apply filters on events admin nd user can accss

	//Following are only 
	Route::group(['middleware' => ['adminauth']], function(){
		Route::post('register', 'API\UserController@register');		//Only admin can create users
		//Route::post('details', 'API\UserController@details');

		//Location Crud Operations
		Route::post('locations', 'API\LocationController@create');				//For create location
		Route::get('lists/location', 'API\LocationController@list');			//For fetch all location
		Route::post('locations/{id}', 'API\LocationController@update');			//For update all location
		Route::delete('{id}/location', 'API\LocationController@delete');		//For delete location
		Route::post('locationEventList', 'API\LocationController@locationwiseEvents');  	//Locationswise events counts

		//Category Crud Operations
		Route::get('categoryEventList/{category_id}/category', 'API\CategoryController@categoryEvent');  
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

