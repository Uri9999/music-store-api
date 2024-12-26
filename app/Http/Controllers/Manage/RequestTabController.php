<?php

namespace App\Http\Controllers\Manage;

use App\Interfaces\RequestTabServiceInterface;
use App\Models\RequestTab;
use Illuminate\Http\JsonResponse;
use App\Services\ApiResponseService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RequestTab\UpdateReceiverRequest;
use App\Http\Requests\RequestTab\UpdateStatusRequest;

class RequestTabController extends Controller
{
    protected RequestTabServiceInterface $requestTabService;

    public function __construct(RequestTabServiceInterface $requestTabService)
    {
        $this->requestTabService = $requestTabService;
    }

    public function index(Request $request): JsonResponse
    {
        $paginator = $this->requestTabService->index($request);

        return ApiResponseService::paginate($paginator);
    }

    public function updateReceiver(UpdateReceiverRequest $request, RequestTab $requestTab): JsonResponse
    {
        $this->requestTabService->update($requestTab, $request->validated());

        return ApiResponseService::success(null, 'Cập nhật thành công.');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->requestTabService->delete($id);

        return ApiResponseService::success(null, 'Xóa thành công.');
    }

    public function updateStatus(UpdateStatusRequest $request, RequestTab $requestTab): JsonResponse
    {
        $requestTab = $this->requestTabService->updateStatus($requestTab, $request->get('status'));

        return ApiResponseService::success($requestTab, 'Cập nhật thành công.');
    }
}
