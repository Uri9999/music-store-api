<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tab\TabRequest;
use App\Interfaces\TabServiceInterface;
use App\Models\Tab;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Tab\TabIndexRequest;

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

        return ApiResponseService::paginate($tabs);
    }

    public function getNewTab(): JsonResponse
    {
        $tabs = $this->tabService->getNewTab();

        return ApiResponseService::success($tabs);
    }

    public function getRandomTab(): JsonResponse
    {
        $tabs = $this->tabService->getRandomTab();

        return ApiResponseService::success($tabs); 
    }

    public function show($id): JsonResponse
    {
        $tab = $this->tabService->show($id);

        return ApiResponseService::success($tab);
    }

    public function update(TabRequest $request, Tab $tab): JsonResponse
    {
        $updatedTab = $this->tabService->update($tab, $request->validated());

        return ApiResponseService::success($updatedTab);
    }

    public function destroy(Tab $tab): JsonResponse
    {
        return ApiResponseService::success($this->tabService->delete($tab), 'Tab deleted successfully');
    }

    public function getTabByIds(Request $request): JsonResponse
    {
        $tabs = $this->tabService->getTabByIds($request->get('ids'));

        return ApiResponseService::success($tabs);
    }
}
