<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserSubscription\RegisterRequest;
use App\Interfaces\UserSubscriptionServiceInterface;
use App\Models\Subscription;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;

class UserSubscriptionController extends Controller
{
    protected UserSubscriptionServiceInterface $service;

    public function __construct(UserSubscriptionServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getMyUserSubscription(Request $request): JsonResponse
    {
        $list = $this->service->getMyUserSubscription($request->user()->getKey());

        return ApiResponseService::paginate($list);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $userSubscription = $this->service->register($request);

        return ApiResponseService::success($userSubscription, 'Đăng ký thành công.');
    }

    public function showSubscription(int $id): JsonResponse
    {
        $subscription = Subscription::find($id);

        return ApiResponseService::success($subscription);
    }

    public function listSubscription(): JsonResponse
    {
        $subs = Subscription::all();

        return ApiResponseService::collection($subs);
    }
}
