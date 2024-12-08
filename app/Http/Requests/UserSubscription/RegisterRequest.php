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
            'subscription_id' => 'bail|exists:subscriptions,id',
            'note' => 'nullable|string',
            'bill' => 'bail|nullable|max:2048',
            'referral_code' => 'nullable|string|exists:users,referral_code',
        ];
    }
}
