<?php

use App\Http\Controllers\Auth\GetMeController;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::prefix('category')->controller(CategoryController::class)->group(function(){
    Route::get('/','index');
    Route::post('create','store');
    Route::get('/{category}','show');
    Route::put('/update/{category}','update');
    Route::delete('/delete/{category}','destroy');
});

Route::prefix('post')->controller(PostController::class)->group(function(){
    Route::get('/','index');
    Route::post('create','store');
    Route::get('/{post}','show');
    Route::put('/update/{post}','update');
    Route::delete('/delete/{post}','destroy');
});

Route::prefix('auth')->group(function(){
    Route::post('/register',RegisterUserController::class);
    Route::post('/login',LoginUserController::class);
    Route::get('/me',GetMeController::class)->middleware('auth:sanctum');
});