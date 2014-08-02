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

Route::get('/', function(){
	return View::make('welcome');
});

#create a new organization
Route::get('/create-organization', function() {
	return View::make('createOrganization');
});

#handle new organzation submission
Route::post('/create-organization', function(){
	//
});

#add a new user
Route::get('/create-user', function() {
	return View::make('createUser');
});

#handle new user submission
Route::post('create-user', function() {

});

Route::get('create-flatplan', function() {
	return View::make('createFlatplan');
});

Route::get('create-page', function() {
	return View::make('createPage');
});

Route::get('view-page', function() {
	return View::make('viewPage');
});

#show a specific user
Route::get('/user/{username}', array(function($username) {
	echo "Show the profile for ".$username;
}));

#edit a user
Route::get('/user/{username}/edit', array(function($username) {
	echo "Edit the profile for ".$username;
}));

#handle user edits
Route::post('/user/{username}/edit', array(function($username) {

}));

#create/edit an assignment for a user
Route::get('/user/{username}/assign', array(function($username) {
	echo "create an assignment for ".$username;
}));

#handle user assignment creation/edit
Route::post('/user/{username}/assign', array(function($username) {

}));

#show all a user's assignments
Route::get('/user/{username}/assignments', array(function($username) {
	echo "show all of ".$username."'s assignments.";
}));

#show a specific assignment for a user
Route::get('/user/{username}/assignment/{assignment}', array(function($username, $assignment) {
	echo "show assignment number ".$assignment." for ".$username;
}));

#show an organization homepage
Route::get('/{organization}', function ($organization) {
	echo "This is the ".$organization." organization";
});

#edit an organization
Route::get('/{organization}/edit', array(function($organization) {
	echo "This will edit the ".$organization." organization.";
}));

#handle edits to an organization
Route::get('/{organization}/edit', array(function($organization) {

}));

#create a new flatplan
Route::get('/{organization}/new-flatplan', array(function($organization) {
	echo "This will create a new flatplan in the ".$organization." organization.";
}));

#show a flatplan
Route::get('/{organization}/{flatplan}', array(function($organization, $flatplan) {
	echo "show the ".$flatplan." flatplan in the ".$organization." organization.";
}));

#edit a flatplan
Route::get('/{organization}/{flatplan}/edit', array(function($organization, $flatplan) {
	echo "edit the ".$flatplan." flatplan in the ".$organization." organization.";
}));

Route::post('/{organization]/{flatplan}/edit', array(function($organization, $flatplan) {

}));

#add a page to a flatplan
Route::get('/{organization}/{flatplan}/new-page', array(function($organization, $flatplan) {
	echo "create a new page in the ".$flatplan." flatplan in the ".$organization." organization.";
}));

#handle adding new page to a flatplan
Route::post('/{organization}/{flatplan}/new-page', array(function($organization, $flatplan) {

}));

#show all assignments in an flatplan
Route::get('/{organization}/{flatplan}/assignments', array(function($organization, $flatplan) {
	echo "show all assignments in the ".$flatplan." of the ".$organization." organization.";
}));

#show a page to a flatplan
Route::get('/{organization}/{flatplan}/{page}', array(function($organization, $flatplan, $page) {
	echo "show page ".$page." of the ".$flatplan." flatplan in the ".$organization." organization.";
}));

#Edit a page in a flatplan
Route::get('/{organization}/{flatplan}/{page}/edit', array(function($organization, $flatplan, $page) {
	echo "edit page ".$page." of the ".$flatplan." flatplan in the ".$organization." organization.";
}));

#handle page edits
Route::post('/{organization}/{flatplan}/{page}/edit', array(function($organization, $flatplan, $page) {

}));

#create/edit an assignment for a page
Route::get('/{organization}/{flatplan}/{page}/assign', array(function($organization, $flatplan, $page) {
	echo "create an assignment for page ".$page." of the ".$flatplan." flatplan in the ".$organization." organization.";
}));

#handle assignment edits
Route::post('/{organization}/{flatplan}/{page}/assign', array(function($organization, $flatplan, $page) {

}));

