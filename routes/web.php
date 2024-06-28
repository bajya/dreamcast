<?php

use Illuminate\Support\Facades\Route;
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
Route::get('clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    // return what you want
});
/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@welcome')->name('welcome');
Route::group(['middleware' => ['auth']], function() {
	Route::group(['prefix'=>'admin','middleware' => ['auth','admin']], function() {
    	// Index and dashboard 
		Route::get('/', ['uses' => 'Backend\HomeController@index'])->name('dashboard');
		Route::get('change-password/edit', ['uses' => 'Backend\HomeController@changePassword'])->name('changepassword');
		Route::post('change-password', ['uses' => 'Backend\HomeController@changePassword'])->name('changepasswordPost');



		//users Module
		Route::get('users/list', ['uses' => 'UserController@index'])->name('users');
		Route::post('usersAjax', ['uses' => 'UserController@usersAjax'])->name('usersAjax');
		Route::get('users/add', ['uses' => 'UserController@create'])->name('createUsers');
		Route::post('users/store', ['uses' => 'UserController@store'])->name('addUsers');
		Route::get('users/edit/{id?}', ['uses' => 'UserController@edit'])->name('editUsers');
		Route::post('users/update/{id?}', ['uses' => 'UserController@update'])->name('updateUsers');
		Route::get('users/view/{id?}', ['uses' => 'UserController@show'])->name('viewUsers');
		Route::get('users/checkUsers/{id?}', ['uses' => 'UserController@checkUsers'])->name('checkUsers');
	});
});
