<?php

namespace App\Http\Controllers;

use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Media\UploadRequest;

class MediaController extends Controller
{
    public function upload(UploadRequest $request): JsonResponse
    {
        $user = $request->user();
        $collection = $request->get('collection');

        $media = $user->addMediaFromRequest('file')->toMediaCollection($collection);

        return ApiResponseService::success($media, 'Thêm file thành công.');
    }
}
