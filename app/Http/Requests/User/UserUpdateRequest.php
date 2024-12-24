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
            'gender' => [Rule::in([User::GENDER_MALE, User::GENDER_FEMALE, User::GENDER_OTHER])],
            'role_id' => [Rule::in([Role::ROLE_STAFF, Role::ROLE_AFFILIATE, Role::ROLE_USER])],
            'status' => [Rule::in([User::STATUS_ACTIVE, User::STATUS_DISABLE, User::STATUS_LOCKED])],
            'dob' => 'date_format:Y-m-d',
            'media_avatar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'commission_rate' => 'min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Tên không được để trống',
            'name.min' => 'Tên tối thiểu 6 ký tự',

            'gender.in' => 'Giới tính không hợp lệ',

            'role_id.in' => 'Cấp bậc không hợp lệ',

            'status.in' => 'Trạng thái không hợp lệ',

            'dob.date_format' => 'Ngày sinh không hợp lệ',

            'media_avatar.image' => 'Ảnh không hợp lệ',
            'media_avatar.mimes' => 'Ảnh không hợp lệ',
            'media_avatar.max' => 'Kích thược tối đa 2048 KB',

            'commission_rate.min' => 'Tỉ lệ % hoa hồng tối thiểu 0',
            'commission_rate.max' => 'Tỉ lệ % hoa hồng tối đa 100',
        ];
    }
}
