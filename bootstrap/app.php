<?php

use App\API\Res\Facades\Response;
use App\Exceptions\RequestException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function () {
            Route::prefix('api')->middleware('api')->group(function () {
                // Api V1
                Route::prefix('v1')->group(__DIR__.'/../routes/api_v1.php');
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(fn () => true);

        $exceptions->render(function (RequestException $exception) {
            return Response::withStatus(500)->withMessage('Something is wrong. try again later!')->send();
        });
    })->create();
