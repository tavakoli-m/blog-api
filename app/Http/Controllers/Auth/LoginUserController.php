<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginUserRequest $request)
    {
        $inputs = $request->validated();

        if(!Auth::attempt($inputs)){
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'عملیات با موفقیت انجام نشد'
            ]);
        }


        $user = Auth::user();

        $access_token = $user->createToken('API TOKEN',['*'],now()->addMonth())->plainTextToken;

        $auth_cookie = cookie('auth_token', Crypt::encryptString($access_token), 43200);


        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $user->updated_at->format('Y-m-d H:i:s')
                ],
            ],
            'message' => 'عملیات با موفقیت انجام شد'
        ])->withCookie($auth_cookie);
    }
}
