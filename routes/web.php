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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', 'HomeController@welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/createEmployee', function () {
    if (Auth::user()->role == 'admin') {
    	return view('employee.create_employee');
    } else {
    	return abort(404);
    }
});

Route::post('/addEmployee', 'HomeController@addEmployee')->name('addEmployee');
Route::post('/updateEmpProfile', 'HomeController@updateEmpProfile')->name('updateEmpProfile');
Route::get('/markPresent', 'HomeController@markPresent')->name('markPresent');

Route::get('/editEmpDetails', function () {
	if (Auth::user()->role == 'employee') {
    	return view('employee.edit_employee');
    } else {
    	return abort(404);
    }
    
});

Route::get('/getAttendance/{date}','HomeController@getAttendance');

