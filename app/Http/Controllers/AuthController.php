<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\AuthServiceInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\VerifyUserRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\LoginResource;
use App\Models\User;

class AuthController extends Controller
{
    protected AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());

        return ApiResponseService::item($user, 'Đăng ký tài khoản thành công, chúng tôi đã gửi email xác thực, hãy kiểm tra email của bạn (trong khoảng 10p mà không có email, xin hãy liên hệ với admin).', 201);
    }

    public function verifyUser(VerifyUserRequest $request): JsonResponse
    {
        $user = $this->authService->verifyUser($request->get('email'), $request->get('token'));

        return ApiResponseService::item($user, 'Xác thực thành công, bạn đã có thể đăng nhập.', 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        if (!$result) {
            return ApiResponseService::error('Invalid credentials', 401);
        }
        $resource = new LoginResource($result);

        return ApiResponseService::success($resource, 'Đăng nhập thành công.');
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return ApiResponseService::success(null, 'Đăng xuất thành công.');
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);
        $user = $userRepository->where('email', $request->get('email'))->first();
        $this->authService->forgotPassword($user);

        return ApiResponseService::success(null, 'Chúng tôi đã gửi email xác nhận quên mật khẩu đến bạn. Vui lòng kiểm tra email (trong khoảng 10p mà không có email, xin hãy liên hệ với admin).');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);
        $user = $userRepository->where('email', $request->get('email'))->first();
        $this->authService->resetPassword($user, $request->get('token'));

        return ApiResponseService::success(null, 'Thay đổi mật khẩu thành công, vui lòng kiểm tra email (trong khoảng 10p mà không có email, xin hãy liên hệ với admin).');
    }

    public function getInfo(Request $request): JsonResponse
    {
        $user = $request->user()->load([
            'media' => function ($query) {
                $query->whereIn('collection_name', [User::MEDIA_AVATAR]);
            }
        ]);

        $resource = new AuthResource($user);

        return ApiResponseService::success($resource);
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $this->authService->updateProfile($request);

        return ApiResponseService::success(null, 'Cập nhật thành công.');
    }
}
