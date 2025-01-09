<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tab\TabRequest;
use App\Interfaces\TabServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Tab\TabIndexRequest;
use App\Http\Resources\TabResource;

class TabController extends Controller
{
    protected TabServiceInterface $tabService;

    public function __construct(TabServiceInterface $tabService)
    {
        $this->tabService = $tabService;
    }

    public function index(TabIndexRequest $request): JsonResponse
    {
        $tabs = $this->tabService->index($request);

        return ApiResponseService::paginate($tabs, 'Success', 200, TabResource::class);
    }

    public function getNewTab(): JsonResponse
    {
        $tabs = $this->tabService->getNewTab();
        $resource = TabResource::collection($tabs);

        return ApiResponseService::success($resource);
    }

    public function getRandomTab(): JsonResponse
    {
        $tabs = $this->tabService->getRandomTab();
        $resource = TabResource::collection($tabs);

        return ApiResponseService::success($resource); 
    }

    public function show(Request $request, string $slug): JsonResponse
    {
        $tab = $this->tabService->showForUser($slug, $request);
        $resource = new TabResource($tab);
        
        return ApiResponseService::success($resource);
    }

    public function getTabByIds(Request $request): JsonResponse
    {
        $tabs = $this->tabService->getTabByIds($request->get('ids'));

        return ApiResponseService::success($tabs);
    }

    public function getTabByUserId(int $id): JsonResponse
    {
        $tabs = $this->tabService->getTabByUserId($id);

        return ApiResponseService::paginate($tabs, 'Success', 200, TabResource::class);
    }
}
