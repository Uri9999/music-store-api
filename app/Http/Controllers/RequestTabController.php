<?php

namespace App\Http\Controllers;

use App\Interfaces\RequestTabServiceInterface;
use App\Models\RequestTab;
use Illuminate\Http\JsonResponse;
use App\Services\ApiResponseService;
use App\Http\Requests\RequestTab\StoreTabRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestTabController extends Controller
{
    protected RequestTabServiceInterface $requestTabService;

    public function __construct(RequestTabServiceInterface $requestTabService)
    {
        $this->requestTabService = $requestTabService;
    }

    public function index(): JsonResponse
    {
        $paginator = $this->requestTabService->index();

        return ApiResponseService::paginate($paginator);
    }

    public function getByReceiverId(int $receiverId): JsonResponse
    {
        $paginator = $this->requestTabService->getByReceiverId($receiverId);

        return ApiResponseService::paginate($paginator);
    }

    public function getCreatedByMy(Request $request): JsonResponse
    {
        $tabs = $this->requestTabService->getCreatedByMy($request->user()->getKey());

        return ApiResponseService::success($tabs);
    }

    public function show(int $id): JsonResponse
    {
        $requestTab = $this->requestTabService->getById($id);

        return ApiResponseService::success($requestTab);
    }

    public function store(StoreTabRequest $request): JsonResponse
    {
        $attrs = $request->validated();
        $attrs['user_id'] = $request->user()->getKey();
        $requestTab = $this->requestTabService->create($attrs);

        return ApiResponseService::success($requestTab);
    }

    public function update(StoreTabRequest $request, RequestTab $requestTab): JsonResponse
    {
        $requestTab = $this->requestTabService->update($requestTab, $request->validated());

        return ApiResponseService::success($requestTab);
    }

    public function statusUpdate(Request $request, RequestTab $requestTab): JsonResponse
    {
        $requestTab = $this->requestTabService->statusUpdate($requestTab, $request->get('status'));

        return ApiResponseService::success($requestTab);
    }

    public function destroy(RequestTab $requestTab): JsonResponse
    {
        $result = $this->requestTabService->delete($requestTab);

        return ApiResponseService::success($result, 'Xóa thành công.');
    }
}
