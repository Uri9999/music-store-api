<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Interfaces\DeviceTokenServiceInterface;
use App\Models\DeviceToken;
use Kreait\Firebase\Messaging\Notification;
use App\Services\ApiResponseService;
use App\Services\FCMService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    protected DeviceTokenServiceInterface $service;

    public function __construct(DeviceTokenServiceInterface $service)
    {
        $this->service = $service;
    }

    public function store(Request $request): JsonResponse
    {
        $attrs = [
            'name' => $request->userAgent(),
            'token' => $request->get('token'),
            'user_id' => $request->user()->getKey(),
        ];
        $device = $this->service->store($attrs);

        return ApiResponseService::success($device, 'ok');
    }

    public function delete(): JsonResponse
    {
        return ApiResponseService::success(null, 'ok');
    }

    public function sendDemoToFirstToken(Request $request): JsonResponse
    {
        $notification = Notification::create('Chào mừng', 'Đây là thông báo thử nghiệm');
        $data = ['key' => 'value'];
        $deviceToken = DeviceToken::first()->token;
        $fcmService = app(FCMService::class); // Khởi tạo FCMService thông qua Laravel container
        $fcmService->send('token', $deviceToken, $notification, $data, 1);

        return ApiResponseService::success(null, 'ok');
    }
}
