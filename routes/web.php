<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::prefix('practice')->group(function(){
     Route::controller(SalesController::class)->group(function(){
       Route::get('/jobs','index');
       Route::post('/jobs','upload')->name('jobs.upload');
     });
});
