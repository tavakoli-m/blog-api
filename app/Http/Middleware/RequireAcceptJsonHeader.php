<?php

namespace App\Http\Middleware;

use App\API\Res\Facades\Response as ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireAcceptJsonHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('accept') == 'application/json') {
            return $next($request);
        }

        return ApiResponse::withStatus(400)->withMessage('The Accept header must be application/json.')->send();
    }
}
