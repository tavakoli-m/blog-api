<?php

namespace App\Http\Controllers\V1\Auth;

use App\API\Req\Request;
use App\API\Res\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $result = app(Request::class)(function () use ($request) {
            $user = User::where('email', $request->input('id'))->orWhere('phone', $request->input('id'))->first();

            if ($user == null) {
                return false;
            } elseif (!Hash::check($request->input('password'), $user->password)) {
                return false;
            }

            return $user->createToken($request->userAgent())->plainTextToken;
        });


        if (! $result->data) {
            return Response::withStatus(401)->withMessage('invalid data')->send();
        }

        return Response::withStatus(200)->withData(['token' => $result->data])->send();
    }
}
