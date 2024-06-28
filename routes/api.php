<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthApiController;
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

Route::get("login", "Api\ApiController@appLogin")->name('login');

Route::middleware('auth:api')->group(function () {
    Route::post("addUser", "Api\AuthApiController@addUser");
    Route::post("userList", "Api\AuthApiController@userList");
    
});
