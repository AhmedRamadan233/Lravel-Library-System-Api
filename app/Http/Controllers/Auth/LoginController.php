<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            $user->tokens()->delete();
            $token = $user->createToken(request()->userAgent());
            return response()->json([
                'token' => $token->plainTextToken,
                'name' => $user->first_name,
                'success' => "Login successful",
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
