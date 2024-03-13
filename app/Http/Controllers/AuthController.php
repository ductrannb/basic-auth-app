<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetOtpRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendOtpJob;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function alo()
    {
        return response()->json(['message' => 'Alo']);
    }
    public function login(LoginRequest $request)
    {
        $accountKey = filter_var($request->account, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
        $credentials = [
            $accountKey => $request->account,
            'password' => $request->password
        ];

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (auth()->user()->verified_email_at == null) {
            return  response()->json(['message' => 'Account is not verify'], Response::HTTP_BAD_REQUEST);
        }

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        return response()->json($user, 201);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function getOtp(GetOtpRequest $request)
    {
        $otp = rand(100000, 999999);
        $email = $request->email;
        Otp::create([
            'email' => $email,
            'otp' => $otp
        ]);
        dispatch(new SendOtpJob($email, $otp));
        return response()->json(['message' => 'Sent OTP to your email. Please check your email for OTP code.'], 200);
    }

    public function verifyOtp(OtpRequest $request)
    {
        $otp = Otp::where('email', $request->email)->where('otp', $request->otp)->where('is_used', false)->latest()->first();
        auth()->user()->verified_email_at = now();
        auth()->user()->update();
        if (! $otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }
        $otp->update(['is_used' => true]);
        return response()->json(['message' => 'OTP verified']);
    }
}
