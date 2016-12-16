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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::resource('assignments', 'AssignmentController');

Route::group(['prefix' => 'teacher'], function () {
	Route::get('/', 'Teacher\HomeController@index');
	Route::get('/home', 'Teacher\HomeController@index');

	Route::resource('assignments', 'Teacher\AssignmentController', ['as' => 'teacher']);
	Route::resource('classes', 'Teacher\ClassesController', ['as' => 'teacher']);
});

