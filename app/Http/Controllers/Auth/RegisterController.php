<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'gender' => $validatedData['gender'],
            'hire_date' => $validatedData['hire_date'],
            'salary' => $validatedData['salary'] ?? 3500,
            'birth_date' => $validatedData['birth_date'],
            'image' => $validatedData['image'] ?? null,
        ]);

        $token = $user->createToken('user', ['app:all']);

        return response()->json([
            'token' => $token->plainTextToken,
            'role' => $user->getRoleNames()[0],
            'success' => 'New account successfully created',
        ], 200);
    }
}
