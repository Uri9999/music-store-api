<?php

namespace App\Http\Requests\UserSubscription;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subscription_id' => 'bail|required|exists:subscriptions,id',
            'note' => 'nullable|string',
            'bill' => 'bail|nullable|max:2048',
            'referral_code' => 'nullable|string|exists:users,referral_code',
        ];
    }

    public function messages(): array
    {
        return [
            'subscription_id.required' => 'Subscription không được để trống',
            'subscription_id.exists' => 'Subscription không tồn tại',

            'note.string' => 'Ghi chú không được để trống',

            'bill.max' => 'Kích thước tối đa 2048 KB',

            'referral_code.string' => 'Mã giới thiệu không hợp lệ',
            'referral_code.exists' => 'Mã giới thiệu không tồn tại',
        ];
    }
}
