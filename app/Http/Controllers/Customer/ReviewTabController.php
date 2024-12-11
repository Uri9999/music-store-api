<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewTab\ReviewTabStoreRequest;
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

    public function store(ReviewTabStoreRequest $request): JsonResponse
    {
        $attrs = $request->validated();
        $attrs['user_id'] = $request->user()->getKey();

        $review = $this->service->store($attrs);

        return ApiResponseService::success($review, 'Đánh giá thành công.');
    }

}
