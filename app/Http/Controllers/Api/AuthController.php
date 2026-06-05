<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DTOs\ApiResponse;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required']]);

        if (! Auth::attempt($credentials)) {
            LoginHistory::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'successful' => false,
                'logged_in_at' => now(),
            ]);

            return ApiResponse::error('Invalid credentials.', 422);
        }

        $user = $request->user();
        $user->update(['last_login_at' => now()]);
        LoginHistory::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_name' => $request->header('X-Device-Name', 'API Client'),
            'successful' => true,
            'logged_in_at' => now(),
        ]);

        return ApiResponse::success([
            'token' => $user->createToken('api')->plainTextToken,
            'user' => $user->load('employee.department'),
        ], 'Authenticated.');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();
        return ApiResponse::success(message: 'Logged out.');
    }
}
