<?php

/**
 * Custom validation rules to check whether an input is odd or even.
 */

	Validator::extend('even', function($field, $value, $parameters){
 		return $value % 2 == 0;
	});	
	Validator::extend('odd', function($field,$value,$parameters){
	 	return $value %2 != 0;
	});



/*
|--------------------------------------------------------------------------
| Application Routes
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function(){
	return View::make('welcome');
});


### UserController (RESTful)
Route::resource('user', 'UserController');
### UserController (other)
Route::get('/signup', array('before'=>'guest', 'uses'=>'UserController@create'));
Route::get('/login', array('before'=>'guest', 'uses'=>'UserController@getLogin'));
Route::post('/login', array('before'=>'guest', 'uses'=>'UserController@postLogin'));
Route::get('/logout', array('uses'=>'UserController@getLogout'));

### OrganizationController
Route::get('/create-organization', 'OrganizationController@getCreate');
Route::post('/create-organization', 'OrganizationController@postCreate');
Route::get('/{slug}', 'OrganizationController@getOrganization');
Route::get('/{slug}/edit', 'OrganizationController@getEdit');
Route::put('/{slug}/edit', 'OrganizationController@putEdit');
Route::post('/{slug}/add-member', 'OrganizationController@postAddMember');


### FlatplanController
Route::get('/{slug}/create-flatplan/', 'FlatplanController@getCreateFlatplan');
Route::post('/{slug}/create-flatplan/', 'FlatplanController@postCreateFlatplan');
Route::get('/{slug}/{plan}', 'FlatplanController@getViewFlatplan');
Route::get('/{slug}/{plan}/edit', 'FlatplanController@getEditFlatplan');
Route::put('/{slug}/{plan}/edit', 'FlatplanController@putEditFlatplan');


### PageController
Route::get('/{slug}/{plan}/create-page', 'PageController@getCreatePage');
Route::post('/{slug}/{plan}/create-page', 'PageController@postCreatePage');
Route::get('/{slug}/{plan}/{number}', 'PageController@getViewPage');
Route::get('/{slug}/{plan}/{number}/edit', 'PageController@getEditPage');
Route::put('/{slug}/{plan}/{number}/edit', 'PageController@putEditPage');


### AssignmentController
Route::post('/{slug}/{plan}/{number}/create-assignment', 'AssignmentController@postCreateAssignment');
Route::get('/{slug}/{plan}/{number}/assignment/{id}', 'AssignemtnController@getEditAssignment');
Route::put('/{slug}/{plan}/{number}/assignment/{id}', 'AssignmentController@putEditAssignment');
