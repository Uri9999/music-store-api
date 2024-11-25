<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search_name' => 'bail|string',
            'status' => ['nullable'],
            'roles' => ['nullable', 'array'],
            'genders' => ['nullable', 'array'],
        ];
    }
}
