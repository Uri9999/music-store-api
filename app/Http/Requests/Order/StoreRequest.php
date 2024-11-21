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
                'required',
                'exists:tabs,id',
                function ($attribute, $value, $fail) {
                    /** @var OrderItemRepositoryInterface $orderItemRepository */
                    $orderItemRepository = app(OrderItemRepositoryInterface::class);
                    $userId = Auth::user()->id;
                    $tab = $orderItemRepository->where('user_id', $userId)->where('tab_id', $value)->first();

                    if ($tab) {
                        return $fail("Bài tab '$tab->name' đã được mua rồi");
                    }
                },
            ],
            'note' => 'nullable|string',
            'bill' => 'bail|nullable|max:2048',
        ];
    }
}
