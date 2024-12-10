<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewTab\ReviewTabIndexRequest;
use App\Interfaces\ReviewTabServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewTabController extends Controller
{
    protected ReviewTabServiceInterface $service;

    public function __construct(ReviewTabServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(ReviewTabIndexRequest $request): JsonResponse
    {
        $paginator = $this->service->index($request);

        return ApiResponseService::paginate($paginator);
    }

    public function disable(int $id): JsonResponse
    {
        $this->service->disable($id);

        return ApiResponseService::success(null, 'Ẩn đánh giá thành công.');
    }

    public function enable(int $id): JsonResponse
    {
        $this->service->enable($id);

        return ApiResponseService::success(null, 'Hiện đánh giá thành công.');
    }
}
