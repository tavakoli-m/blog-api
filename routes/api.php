<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('category')->controller(CategoryController::class)->group(function(){
    Route::get('/','index');
    Route::post('create','store');
    Route::get('/{category}','show');
    Route::put('/update/{category}','update');
    Route::delete('/delete/{category}','destroy');
});