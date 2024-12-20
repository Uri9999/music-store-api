<?php

namespace App\Http\Controllers\Customer;

use App\Interfaces\UserServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected UserServiceInterface $service;

    public function __construct(UserServiceInterface $service)
    {
        $this->service = $service;
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->service->show($id);
        $resource = new UserResource($user);

        return ApiResponseService::success($resource, 'Chi tiết user.');
    }
}
