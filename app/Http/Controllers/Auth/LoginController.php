<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return response()->json(['message' => 'Login successful!']);
        }

        return response()->json(['message' => 'Invalid credentials.'], 401);
    }
}
