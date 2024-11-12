<?php

namespace App\Services;

use App\Interfaces\AuthServiceInterface;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService implements AuthServiceInterface
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
        return $this->authRepository->createUser($data);
    }

    public function login(array $data)
    {
        $user = $this->authRepository->getUserByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        // Tạo token cho người dùng
        return $user->createToken('auth_token')->plainTextToken;
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
    }
}
