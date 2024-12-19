<?php

namespace App\Http\Controllers\Manage;

use App\Interfaces\UserServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected UserServiceInterface $service;

    public function __construct(UserServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(UserIndexRequest $request): JsonResponse
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

    public function show(int $id): JsonResponse
    {
        $user = $this->service->show($id);
        $resource = new UserResource($user);

        return ApiResponseService::success($resource, 'Chi tiết user.');
    }

    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        $this->service->update($id, $request);

        return ApiResponseService::success(null, 'Cập nhật thông tin thành công.');
    }

    public function getManager(Request $request): JsonResponse
    {
        $users = $this->service->getManager($request);

        return ApiResponseService::collection($users);
    }
}
