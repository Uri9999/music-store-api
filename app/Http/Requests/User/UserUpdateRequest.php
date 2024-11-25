<?php

namespace App\Http\Requests\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'bail|string|min:6',
            'gender' => [Rule::in([User::GENDER_MALE, User::GENDER_FEMALE])],
            'role_id' => [Rule::in([Role::ROLE_STAFF, Role::ROLE_AFFILIATE, Role::ROLE_USER])],
            'status' => [Rule::in([User::STATUS_ACTIVE, User::STATUS_DISABLE, User::STATUS_LOCKED])],
            'dob' => 'date_format:Y-m-d',
            'media_avatar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ];
    }
}
