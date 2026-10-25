<?php

use App\API\Res\Facades\Response;
use App\Exceptions\RequestException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $exceptions->shouldRenderJsonWhen(function(){
            return true;
        });

        $exceptions->render(function (RequestException $exception) {
            return Response::withStatus(500)->withMessage('Something is wrong. try again later!')->send();
        });

        // 422 status code
        $exceptions->render(function (ValidationException $exception, Request $request) {
            return Response::withStatus(422)
                ->withMessage($exception->getMessage())
                ->send();

        });

        // 401 status code (Sanctum)
        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            return Response::withStatus(401)
                ->withMessage($exception->getMessage())
                ->send();

        });

        // 403 status code
        $exceptions->render(function (AccessDeniedHttpException $exception, Request $request) {
            if ($exception->getPrevious() instanceof AuthorizationException) {
                return Response::withStatus(403)
                    ->withMessage($exception->getMessage())
                    ->send();
            }
        });

        // 404 status code
        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            return Response::withStatus(404)
                ->withMessage('not found !!')
                ->send();

        });

        // 405 status code
        $exceptions->render(function (MethodNotAllowedHttpException $exception, Request $request) {
            return Response::withStatus(405)
                ->withMessage('Method Not Allowed !!')
                ->send();
        });

    })->create();
