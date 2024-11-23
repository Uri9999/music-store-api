<?php

namespace App\Http\Requests\Tab;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

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
            'status' => [Rule::in(User::LIST_STATUS)],
            'role_id' => '',
            'gender' => '',
        ];
    }
}
