<?php

namespace App\Http\Requests\Order;

use App\Interfaces\OrderItemRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tab_ids' => 'array',
            'tab_ids.*' => [
                'bail',
                'distinct',
                'required',
                'exists:tabs,id',
                function ($attribute, $value, $fail) {
                    /** @var OrderItemRepositoryInterface $orderItemRepository */
                    $orderItemRepository = app(OrderItemRepositoryInterface::class);
                    $userId = Auth::user()->id;
                    $orderItem = $orderItemRepository->where('user_id', $userId)->where('tab_id', $value)->first();
                    $tabName = $orderItem->meta['name'];
                    if ($orderItem) {
                        return $fail("Bài tab '$tabName' đã được mua hoặc đang trong quá trình xét duyệt thanh toán");
                    }
                },
            ],
            'note' => 'bail|required|string',
            'bill' => 'bail|nullable|max:2048',
        ];
    }
}
