<?php

namespace App\Http\Controllers\V1\Auth;

use App\API\Req\Request;
use App\API\Res\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $result = app(Request::class)(function() use ($request) {
            $inputs = $request->validated();

            $inputs['password'] = Hash::make($inputs['password']);
            $inputs['phone_active_at'] = now();
            $inputs['email_active_at'] = now();

            $user = User::create($inputs);

            $token = $user->createToken($request->userAgent())->plainTextToken;

            return $token;
        });

        return Response::withStatus(200)->withData(['token' => $result->data])->send();
    }
}
