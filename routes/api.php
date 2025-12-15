<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ComissionController;
use App\Http\Controllers\Api\Auth\AuthController;


Route::prefix('auth')->group(function(){
  Route::controller(AuthController::class)->group(function(){
    Route::post('/login','login');
  });
});


Route::prefix('commissions-rules')->group(function(){
    Route::controller(ComissionController::class)->group(function(){
        Route::get('/','index');
        Route::post('/','create');
        Route::get('edit','edit');
        Route::put('update','update');
        Route::delete('delete','delete');

    });
})->middleware('auth:sanctum');
