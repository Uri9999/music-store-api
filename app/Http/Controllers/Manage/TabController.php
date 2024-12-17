<?php

namespace App\Http\Controllers\Manage;

use App\Http\Requests\Tab\TabRequest;
use App\Http\Requests\Tab\TabUpdateRequest;
use App\Http\Resources\TabResource;
use Illuminate\Http\JsonResponse;
use App\Services\ApiResponseService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\TabServiceInterface;

class TabController extends Controller
{
    protected TabServiceInterface $service;

    public function __construct(TabServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $paginator = $this->service->index($request);

        return ApiResponseService::paginate($paginator);
    }

    public function store(TabRequest $request): JsonResponse
    {
        $tab = $this->service->create($request);

        return ApiResponseService::success($tab, 'Tạo tab thành công.', 201);
    }

    public function update(TabUpdateRequest $request, int $id): JsonResponse
    {
        $tab = $this->service->update($id, $request);

        return ApiResponseService::success($tab, 'Cập nhật thành công.', 201);
    }

    public function show(int $id): JsonResponse
    {
        $tab = $this->service->show($id);
        $resource = new TabResource($tab);

        return ApiResponseService::success($resource);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return ApiResponseService::success(null, 'Xóa thành công.');
    }

    public function removeTabImage(int $tabId, int $mediaId): JsonResponse
    {
        $this->service->removeTabImage($tabId, $mediaId);

        return ApiResponseService::success(null, 'Xóa thành công.');
    }
}
