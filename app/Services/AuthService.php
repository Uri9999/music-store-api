<?php

namespace App\Services;

use App\Interfaces\AuthServiceInterface;
use App\Interfaces\AuthRepositoryInterface;
use App\Mail\VerifycationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthService implements AuthServiceInterface
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
        $verificationToken = Str::random(64);
        $data['verification_token'] = $verificationToken;
        $expiresAt = 10; // unit minute
        $data['expires_at'] = Carbon::now()->addMinutes($expiresAt); // Thời gian hết hạn là 10 phút

        $user = $this->authRepository->createUser($data);
        Mail::to($user->email)->send(new VerifycationEmail($verificationToken, $expiresAt));

        return $user;
    }

    public function login(array $data)
    {
        $user = $this->authRepository->getUserByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        // Tạo token cho người dùng
        $token = $user->createToken('auth_token');

        // Lấy thời gian hết hạn từ cấu hình Sanctum
        $expirationMinutes = (int) config('sanctum.expiration', 60);
        $expiresAt = Carbon::now()->addMinutes($expirationMinutes);

        return [
            'token' => $token->plainTextToken,
            'expires_at' => $expiresAt->toDateTimeString(),
            'user' => $user,
        ];
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
    }
}
