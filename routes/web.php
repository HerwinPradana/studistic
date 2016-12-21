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

Route::get('/', 'Student\HomeController@index');
Route::get('/home', 'Student\HomeController@index');

Route::resource('assignments', 'Student\AssignmentController');
Route::get('assignments/{assignment}/attempts/{attempt}', 'Student\AssignmentController@attempt');

Route::resource('classes', 'Student\ClassesController');
Route::get('classes/{classes}/join', 'Student\ClassesController@join');

Route::group(['prefix' => 'teacher'], function () {
	Route::get('/', 'Teacher\HomeController@index');
	Route::get('/home', 'Teacher\HomeController@index');

	Route::resource('assignments', 'Teacher\AssignmentController', ['as' => 'teacher']);
	Route::resource('classes', 'Teacher\ClassesController', ['as' => 'teacher']);
});

