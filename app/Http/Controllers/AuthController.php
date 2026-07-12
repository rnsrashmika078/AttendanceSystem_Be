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

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'role' =>  $data['role'],
            'email' =>  $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        Log::info('Event Triggered!', [
            'data' => $data
        ]);
        $this->generateOTP($user->email, $user->username);

        // Auth::login($user);

        return response()->json([
            "status" => true,
            "message" => "Waiting for OTP Verification",
            "email" => $user->email,
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
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return response()->json(['message' => 'Logged out']);
    }
    public function generateOTP(string $email, string $username)
    {

        Log::info(" generateOTP hit", [
            'message' => "hit the funcion geneateOTP",
            'email' => $email,
        ]);
        OTP::where('email', $email)->where('is_used', false)->delete();
        $otpCode = random_int(100000, 999999);

        OTP::create([
            'email' => $email,
            'code' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(1)
        ]);
        event(new OTPEmailEvent([
            'email' => $email,
            'username' => $username,
            'otp' => $otpCode,
        ]));
    }
    public function verifyOTP(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|numeric|digits:6',
        ]);

        $otp = OTP::where('email', operator: $validate['email'])->where('code', $validate['code'])->first();
        if (!$otp) {
            return response()->json(['message' => 'Invalid OTP.', 'success' => false], 422);
        }


        if ($otp->is_used) {
            return response()->json(['message' => 'OTP already used.', 'success' => false], 422);
        }

        if (Carbon::now()->greaterThan($otp->expires_at)) {
            return response()->json(['message' => 'OTP expired.', 'success' => false], 422);
        }

        $otp->update(['is_used' => true]);
        $user = User::where('email', $validate['email'])->firstOrFail();
        $user->update(['email_verified_at' => now(), 'email_verified' => true]);

        return response()->json([
            "success" => true,
            "message" => "Verification Successful!",
            "user" => $user
        ]);
    }
}
