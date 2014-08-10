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

# /app/routes.php
Route::get('/debug', function() {

    echo '<pre>';

    echo '<h1>environment.php</h1>';
    $path   = base_path().'/environment.php';

    try {
        $contents = 'Contents: '.File::getRequire($path);
        $exists = 'Yes';
    }
    catch (Exception $e) {
        $exists = 'No. Defaulting to `production`';
        $contents = '';
    }

    echo "Checking for: ".$path.'<br>';
    echo 'Exists: '.$exists.'<br>';
    echo $contents;
    echo '<br>';

    echo '<h1>Environment</h1>';
    echo App::environment().'</h1>';

    echo '<h1>Debugging?</h1>';
    if(Config::get('app.debug')) echo "Yes"; else echo "No";

    echo '<h1>Database Config</h1>';
    print_r(Config::get('database.connections.mysql'));

    echo '<h1>Test Database Connection</h1>';
    try {
        $results = DB::select('SHOW DATABASES;');
        echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
        echo "<br><br>Your Databases:<br><br>";
        print_r($results);
    } 
    catch (Exception $e) {
        echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
    }

    echo '</pre>';

});


Route::get('/', function(){
	if(Auth::check()){
		return Redirect::to('/user/'.Auth::user()->username);
	}
	else{
	return View::make('welcome');
	}
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
Route::get('/{slug}/{user}/remove', 'OrganizationController@getConfirmDelete');
Route::delete('{slug}/{user}/remove', 'OrganizationController@deleteRole');

### FlatplanController
Route::get('/{slug}/create-flatplan/', 'FlatplanController@getCreateFlatplan');
Route::post('/{slug}/create-flatplan/', 'FlatplanController@postCreateFlatplan');
Route::get('/{slug}/{plan}', 'FlatplanController@getViewFlatplan');
Route::get('/{slug}/{plan}/edit', 'FlatplanController@getEditFlatplan');
Route::put('/{slug}/{plan}/edit', 'FlatplanController@putEditFlatplan');
Route::get('/{slug}/{plan}/delete','FlatplanController@getConfirmDelete');
Route::delete('/{slug}/{plan}/delete', 'FlatplanController@deleteFlatplan');

### PageController
Route::get('/{slug}/{plan}/create-page', 'PageController@getCreatePage');
Route::post('/{slug}/{plan}/create-page', 'PageController@postCreatePage');
Route::get('/{slug}/{plan}/{number}', 'PageController@getViewPage');
Route::get('/{slug}/{plan}/{number}/edit', 'PageController@getEditPage');
Route::put('/{slug}/{plan}/{number}/edit', 'PageController@putEditPage');
Route::get('/{slug}/{plan}/{number}/delete', 'PageController@getConfirmDelete');
Route::delete('/{slug}/{plan}/{number}/delete', 'PageController@deletePage');

### AssignmentController
Route::post('/{slug}/{plan}/{number}/create-assignment', 'AssignmentController@postCreateAssignment');
Route::get('/{slug}/{plan}/{number}/assignment/{id}', 'AssignmentController@getEditAssignment');
Route::put('/{slug}/{plan}/{number}/assignment/{id}', 'AssignmentController@putEditAssignment');
Route::get('/{slug}/{plan}/{number}/assignment/{id}/delete', 'AssignmentController@getConfirmDelete');
Route::delete('/{slug}/{plan}/{number}/assignment/{id}/delete', 'AssignmentController@deleteAssignment');