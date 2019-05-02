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



Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['web', 'auth']], function(){
	Route::get('/', function () {
	    return Redirect::to('/home');
	});
});

Route::get('/home', 'HomeController@loggingUserAdmin')->name('home');
Route::get('/logout', function(){
   Auth::logout();
   return Redirect::to('login');
});

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () { 
		//basic preview   
		Route::get('user_student', 'AdminController@userStudent')->name('user_student');
		Route::get('user_admin', 'AdminController@userAdmin')->name('user_admin');
		Route::get('theme/{id}', 'AdminController@themes')->name('admin_themes_id');
		Route::get('theme', 'AdminController@themes')->name('admin_themes');
		Route::get('exercises', 'AdminController@exercises')->name('admin_exercises');
		Route::get('profile', 'AdminController@adminProfile')->name('admin_profile');
		Route::get('semesters', 'AdminController@adminSemesters')->name('admin_semesters');
		Route::get('admin_grades', 'AdminController@adminGrades')->name('admin_grades');
		Route::get('user_status', 'AdminController@userStatus')->name('user_status');

		//edit routes
		Route::get('user/edit/{id}', 'AdminController@editUser')->name('user_edit'); 
		Route::get('exercise/edit/{id}', 'AdminController@editExercise')->name('exercise_edit'); 
		Route::get('theme/edit/{id}', 'AdminController@editTheme')->name('theme_edit'); 
		Route::post('adminTheme/edit/{id}', 'AdminController@editAdminTheme');
		Route::post('editCurrentUser', 'AdminController@editCurrentUser');

		//show routes
		Route::get('showGodini/{id}', 'AdminController@showGodini')->name('show_godini');
		Route::get('showTema/{id}', 'AdminController@showTema')->name('show_tema');
		Route::get('show_godiniZaTema/{id}', 'AdminController@showGodinaZaTema')->name('show_godiniZaTema');
		Route::get('admin_overview', 'AdminController@adminOverview')->name('admin_overview'); 
		Route::get('admin_themes_overview/{id}', 'AdminController@adminThemes')->name('admin_themes_overview');
		Route::get('admin_exercises_overview/{id}', 'AdminController@exercisesOverview')->name('admin_exercises_overview');
		Route::get('download_solution/{id}', 'AdminController@download_solution')->name('download_solution');

		//user info
		Route::get('user_info/{id}', 'AdminController@user_info')->name('user_info');
		Route::post('edit_user_profile', 'AdminController@editUserProfile')->name('edit_user_profile');
		
		//add routes
		Route::get('addStudent', 'AdminController@addStudent')->name('add_student');
		Route::get('addAdmin', 'AdminController@addAdmin')->name('add_admin');
		Route::get('addTheme', 'AdminController@addTheme')->name('add_theme');
		Route::get('addExercise', 'AdminController@addExercise')->name('add_exercise');
		Route::post('addPoints/{id}', 'AdminController@addPoints')->name('add_points');
		Route::post('addNewAdmin', 'AdminController@addNewAdmin');
		Route::post('addNewStudent', 'AdminController@addNewStudent');
		Route::post('addNewExercise', 'AdminController@addNewExercise');
});


Route::group(['middleware' => 'user', 'prefix' => 'user'], function () {   
	Route::get('profile', 'UserController@userProfile')->name('user_profile');
	Route::get('grades', 'UserController@userGrades')->name('user_grades');
	Route::get('themes/{id}', 'UserController@userThemes')->name('user_themes');
	Route::get('exercises/{id}', 'UserController@userExercise')->name('user_exercises');
	Route::post('uploadFile', 'UserController@uploadFile')->name('uploadFile');
	Route::post('edit_profile', 'UserController@editProfile')->name('edit_profile');
});

