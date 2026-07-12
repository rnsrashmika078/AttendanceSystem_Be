<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'role' =>  $data['role'],
            'email' =>  $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return response()->json([
            "status" => true,
            "message" => "Successfully Registered in! You will redirected to dashboard",
            "user" => new UserResource($user)
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return response()->json(['message' => 'Invalid credentials', 'status' => false], 401);
        }

        return response()->json([
            "status" => true,
            "message" => "Successfully Logged in!",
            "user" => new UserResource(Auth::user())
        ]);
    }

    public function user()
    {
        return response()->json([
            "message" => "Retrived user details!",
            "user" => new UserResource(Auth::user())
        ]);
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return response()->json(['message' => 'Logged out']);
    }
}
