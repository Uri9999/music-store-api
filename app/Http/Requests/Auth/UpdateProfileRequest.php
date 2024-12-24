<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|string|min:6',
            'phone' => 'bail|string',
            'introduce' => 'nullable|string',
            'gender' => [Rule::in([User::GENDER_MALE, User::GENDER_FEMALE, User::GENDER_OTHER])],
            'dob' => 'required|date_format:Y-m-d',
            'media_avatar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Tên được để trống',
            'name.min' => 'Tên tối thiểu 6 ký tự',

            'phone.string' => 'Số điện thoại không được để trống',

            'introduce.string' => 'Giới thiệu không hợp lệ',

            'gender.in' => 'Giới tính không hợp lệ',

            'dob.required' => 'Ngày sinh không hợp để trống',
            'dob.date_format' => 'Ngày sinh không hợp lệ',
        ];
    }
}
