<?php

namespace App\Http\Controllers;

use App\Interfaces\UserServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserServiceInterface $service;

    public function __construct(UserServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $paginator = $this->service->index($request);

        return ApiResponseService::paginate($paginator);
    }

    public function lock(int $id): JsonResponse
    {
        $this->service->lock($id);

        return ApiResponseService::success(null, 'Khóa tài khoản thành công.');
    }

    public function unlock(int $id): JsonResponse
    {
        $this->service->unlock($id);

        return ApiResponseService::success(null, 'Mở khóa hóa tài khoản thành công.');
    }
}
