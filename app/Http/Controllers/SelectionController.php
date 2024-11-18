<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SelectionController extends Controller
{
    public function index(): JsonResponse
    {
        $selections = [];
        $categories = Category::with('children')->where('parent_id', null)->get();

        $selections['categories'] = $this->format($categories);

        return ApiResponseService::success($selections);
    }

    protected function format($items) {
        $data = null;
        foreach ($items as $item) {
            // dd($category->children);
            $data[] = [
                'label' => $item->name,
                'value' => $item->getKey(),
                'description' => null,
                'children' => count($item->children) > 0 ? $this->format($item->children) : null,
            ];
        }

        return $data;
    }
}
