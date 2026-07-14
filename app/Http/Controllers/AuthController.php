<?php

namespace App\Http\Controllers;

use App\Events\OTPEmailEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\OTP;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\OTPService;

class AuthController extends Controller
{
    private OTPService $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'role' =>  $data['role'],
            'email' =>  $data['email'],
            'reg_number' =>  $data['reg_number'],
            'password' => Hash::make($data['password']),
        ]);

        $this->otpService->sendOTP($user->email, $user->username);


        return response()->json([
            "success" => true,
            "message" => "Waiting for OTP Verification",
            "user" => $user,
        ], 202);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $exist = User::where('email', $validated['email'])->first();


        if (!$exist) {
            return response()->json([
                'message' => 'User not found..Please register before proceed!',
                'success' => false,
                'isVerified' => false,
            ], 404);
        }
        if (!Auth::attempt($validated)) {
            return response()->json(['message' => 'Invalid credentials', 'success' => false], 401);
        }
        $user = Auth::user();

        if (!$user->hasVerifiedEmail()) {
            $this->otpService->sendOTP($user->email, $user->username);
            return response()->json([
                'message' => 'Redirect to verification',
                'success' => true,
                'isVerified' => false,
                "user" => $user
            ], 202);
        }
        Log::info("AUTH USER", [
            'user' => Auth::user()
        ]);
        return response()->json([
            "success" => true,
            "message" => "Successfully Logged in!",
            "user" => new UserResource(Auth::user()),
            'isVerified' => true,

        ], 200);
    }

    public function user()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "User not authenticated!",
            ], 401);
        }
        return response()->json([
            "success" => true,
            "message" => "Retrived user details!",
            "user" => new UserResource(Auth::user())
        ], 200);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return response()->json(['message' => 'Logged out', 'success' => true], 200);
    }
    public function generateOTP(Request $request)

    {
        $validate = $request->validate([
            'email' => 'required',
            'username' => 'required'
        ]);
        Log::info("username and email ", [
            "validate" => $validate,

        ]);
        $this->otpService->sendOTP($validate['email'], $validate['username']);

        return response()->json([
            "success" => true,
            "message" => "OTP has been sent to your email!",
        ], 200);
    }
    public function verifyOTP(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|numeric|digits:6',
        ]);

        try {

            $user = $this->otpService->verifyOTP(
                $validate['email'],
                $validate['code']
            );

            return response()->json([
                "success" => true,
                "message" => "Verification Successful!",
                "user" => $user
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 422);
        }
    }
}
