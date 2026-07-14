<?php

namespace App\Services;

use App\Events\OTPEmailEvent;
use App\Models\OTP;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OTPService
{
    public function sendOTP(string $email, string $username)
    {
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

    public function verifyOTP(string $email, string $code)
    {
        $otp = OTP::where('email', $email)
            ->where('code', $code)
            ->first();

        if (!$otp) {
            throw new \Exception("Invalid OTP.");
        }

        if ($otp->is_used) {
            throw new \Exception("OTP already used.");
        }

        if (Carbon::now()->greaterThan($otp->expires_at)) {
            throw new \Exception("OTP expired.");
        }

        $otp->update([
            'is_used' => true
        ]);

        $user = User::where('email', $email)->firstOrFail();

        $user->update([
            'email_verified_at' => now(),
            'email_verified' => true
        ]);

        Auth::login($user);

        return $user;
    }
}
