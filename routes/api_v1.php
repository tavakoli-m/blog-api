<?php

use App\API\Req\Request;
use App\API\Res\Facades\Response;
use App\Http\Controllers\V1\Admin\CategoryController;
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
});