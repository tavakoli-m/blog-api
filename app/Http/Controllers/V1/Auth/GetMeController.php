<?php

namespace App\Http\Controllers\V1\Auth;

use App\API\Res\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Auth\GetMeApiResource;
use Illuminate\Http\Request;

class GetMeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Response::withStatus(200)->withData(['user' => new GetMeApiResource($request->user())])->send();
    }
}
