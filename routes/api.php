<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkController;

Route::group(['middleware' => 'api','prefix' => 'auth', 'controller' => AuthController::class ], function ($router) {
    Route::post('login','login');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('register', 'register');
    Route::get('me', 'me');
});
Route::prefix('v1')->group(function(){
    Route::group(['prefix' => 'shorten', 'middleware' => 'auth:api', 'controller'=> LinkController::class], function(){
        
        Route::get('/redirect/{url}', 'redirect');
        Route::post('/', 'store');
        Route::put('{url}', 'update');
        Route::delete('{url}', 'destroy');
        Route::get('{url}', 'getUrl');
        Route::get('{url}/stats', 'getUrlStats');

    });
});