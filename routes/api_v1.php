<?php

use App\API\Req\Request;
use App\API\Res\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function(){
    $result = app(Request::class)(function(){
        return [];
    });

    return Response::withData($result->data)->send();
});
