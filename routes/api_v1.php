<?php

use App\API\Req\Request;
use App\API\Res\Facades\Response;
use App\Http\Controllers\V1\Admin\CategoryController;
use App\Http\Controllers\V1\Admin\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function(){
    $result = app(Request::class)(function(){
        return [];
    });

    return Response::withData($result->data)->send();
});

Route::prefix('admin')->group(function(){
    Route::prefix('category')->controller(CategoryController::class)->group(function(){
        Route::get('/','index');
        Route::get('/{category}','show');
        Route::post('/add','store');
        Route::put('/{category}/update','update');
        Route::delete('/{category}/delete','destroy');
    });

    Route::prefix('post')->controller(PostController::class)->group(function(){
        Route::get('/','index');
        Route::get('/categories','categories');
        Route::get('/{post}','show');
        Route::post('/add','store');
        Route::put('/{post}/update','update');
        Route::put('/{post}/change-status','changeStatus');
        Route::delete('/{post}/delete','destroy');
    });
});