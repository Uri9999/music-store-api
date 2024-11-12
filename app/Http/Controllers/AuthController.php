<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());

        return ApiResponseService::item($user, 'User registered successfully.', 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->validated());

        if (!$token) {
            return ApiResponseService::error('Invalid credentials', 401);
        }

        return ApiResponseService::success(['token' => $token], 'User logged in successfully.');
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return ApiResponseService::success(null, 'User logged out successfully.');
    }
}
