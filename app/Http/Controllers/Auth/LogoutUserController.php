<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LogoutUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'data' => [],
            'message' => 'عملیات با موفقیت انجام شد'
        ])->withoutCookie('auth_token');
    }
}
