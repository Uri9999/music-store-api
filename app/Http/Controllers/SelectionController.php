<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Order;
use App\Models\RequestTab;
use App\Models\Role;
use App\Models\User;
use App\Models\UserSubscription;
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

        $selections['request_tab_status'] = [
            [
                'label' => 'Khởi tạo',
                'value' => RequestTab::STATUS_DEFAULT,
            ],
            [
                'label' => 'Đang thực hiện',
                'value' => RequestTab::STATUS_PROCESSING,
            ],
            [
                'label' => 'Hoàn thành',
                'value' => RequestTab::STATUS_COMPLETED,
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

        $selections['order_status'] = [
            [
                'label' => 'Chờ phê duyệt',
                'value' => Order::STATUS_CREATED,
            ],
            [
                'label' => 'Hoàn thành',
                'value' => Order::STATUS_COMPLETED,
            ],
            [
                'label' => 'Đã hủy',
                'value' => Order::STATUS_CANCEL,
            ],
        ];

        $selections['article_status'] = [
            [
                'label' => 'Nháp',
                'value' => Article::STATUS_DRAFT,
            ],
            [
                'label' => 'Công khai',
                'value' => Article::STATUS_PUBLIC,
            ],
            [
                'label' => 'Khóa',
                'value' => Article::STATUS_LOCK,
            ],
        ];

        $selections['article_types'] = [
            [
                'label' => 'Bài viết',
                'value' => Article::TYPE_ARTICLE,
            ],
            [
                'label' => 'Hướng dẫn',
                'value' => Article::TYPE_TUTORIAL,
            ],
            [
                'label' => 'Terms',
                'value' => Article::TYPE_POLICY,
            ],
        ];

        $selections['user_subscription_status'] = [
            [
                'label' => 'Chờ phê duyệt',
                'value' => UserSubscription::STATUS_PENDING,
            ],
            [
                'label' => 'Đã phê duyệt',
                'value' => UserSubscription::STATUS_APPROVED,
            ],
            [
                'label' => 'Đã hủy',
                'value' => UserSubscription::STATUS_REJECTED,
            ],
        ];

        return ApiResponseService::success($selections);
    }

    protected function format($items)
    {
        $data = null;
        foreach ($items as $item) {
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
