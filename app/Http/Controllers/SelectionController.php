<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
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

        $selections['user_status'] = [
            [
                'label' => 'Chưa kích hoạt',
                'value' => User::STATUS_DISABLE,
            ],
            [
                'label' => 'Hoạt động',
                'value' => User::STATUS_ACTIVE,
            ],
            [
                'label' => 'Khóa',
                'value' => User::STATUS_LOCKED,
            ],
        ];

        $selections['user_role'] = [
            [
                'label' => 'Admin',
                'value' => Role::ROLE_ADMIN,
            ],
            [
                'label' => 'Nhân viên',
                'value' => Role::ROLE_STAFF,
            ],
            [
                'label' => 'Affiliate',
                'value' => Role::ROLE_AFFILIATE,
            ],
            [
                'label' => 'Khách hàng',
                'value' => Role::ROLE_USER,
            ],
        ];

        $selections['user_gender'] = [
            [
                'label' => 'Nam',
                'value' => User::GENDER_MALE,
            ],
            [
                'label' => 'Nữ',
                'value' => User::GENDER_FEMALE,
            ],
        ];

        return ApiResponseService::success($selections);
    }

    protected function format($items)
    {
        $data = null;
        foreach ($items as $item) {
            // dd($category->children);
            $data[] = [
                'label' => $item->name,
                'value' => $item->getKey(),
                'key' => $item->getKey(),
                'description' => null,
                'children' => count($item->children) > 0 ? $this->format($item->children) : null,
            ];
        }

        return $data;
    }
}
