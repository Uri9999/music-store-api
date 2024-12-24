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
                    $orderItem = $orderItemRepository->where('tab_id', $value)->whereHas('order', function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })->first();
                    if ($orderItem) {
                        $tabName = $orderItem->meta['name'] ?? '';
                        return $fail("Bài tab '$tabName' đã được mua hoặc đang trong quá trình xét duyệt thanh toán");
                    }
                },
            ],
            'note' => 'bail|required|string',
            'bill' => 'bail|nullable|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'tab_ids.array' => 'Danh sách tab không hợp lệ',
            'tab_ids.*.distinct' => 'Tab không hợp lệ',
            'tab_ids.*.required' => 'Tab không được để trống',
            'tab_ids.*.exists' => 'Tab đã tồn tại',

            'note.required' => 'Ghi chú không được để trống',
            'note.string' => 'Ghi chú không hợp lệ',

            'bill.max' => 'Kích thước tối đa 2048 KB',
        ];
    }
}
