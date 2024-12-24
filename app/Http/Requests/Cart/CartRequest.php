<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tab_id' => 'required|exists:tabs,id',
            'meta' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'tab_id.required' => 'Tab không được để trống',
            'tab_id.exists' => 'Tab không tồn tại',
        ];
    }
}
