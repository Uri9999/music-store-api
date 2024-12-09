<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerStoreRequest;
use App\Http\Requests\Banner\BannerUpdateRequest;
use App\Http\Resources\BannerResource;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    public function index(): JsonResponse
    {
        $banners = Banner::with([
            'media' => function ($query) {
                $query->whereIn('collection_name', [Banner::MEDIA_BANNER]);
            }
        ])->paginate(10);

        return ApiResponseService::paginate($banners, '', 200, BannerResource::class);
    }

    public function store(BannerStoreRequest $request): JsonResponse
    {
        $banner = Banner::create($request->all());

        if ($image = $request->file('image')) {
            $banner->addMedia($image)
                ->toMediaCollection(Banner::MEDIA_BANNER);
        }

        return ApiResponseService::success(null, 'Tạo thành công.');
    }

    public function update(BannerUpdateRequest $request, int $id): JsonResponse
    {
        $banner = Banner::find($id);
        $banner->update($request->all());

        if ($image = $request->file('image')) {
            $banner->clearMediaCollection(Banner::MEDIA_BANNER);
            $banner->addMedia($image)
                ->toMediaCollection(Banner::MEDIA_BANNER);
        }

        return ApiResponseService::success(null, 'Cập nhật thành công.');

    }

    public function destroy(int $id): JsonResponse
    {
        $banner = Banner::find($id);
        $banner->delete();

        return ApiResponseService::success(null, 'Xóa thành công.');
    }

    public function show(int $id): JsonResponse
    {
        $banner = Banner::find($id)->load([
            'media' => function ($query) {
                $query->whereIn('collection_name', [Banner::MEDIA_BANNER]);
            }
        ]);
        $resource = new BannerResource($banner);

        return ApiResponseService::success($resource);
    }

    public function getList(): JsonResponse
    {
        $banners = Banner::with([
            'media' => function ($query) {
                $query->whereIn('collection_name', [Banner::MEDIA_BANNER]);
            }
        ])->get();
        $resource = BannerResource::collection($banners);

        return ApiResponseService::success($resource);
    }
}
