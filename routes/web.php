<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'shorten', 'controller'=> LinkController::class], function(){
    
    Route::get('/redirect/{url}', 'redirect');

});
