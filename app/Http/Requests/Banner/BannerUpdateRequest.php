<?php

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;

class BannerUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.max' => 'Tên tối đa 255 ký tự',

            'description.string' => 'Mô tả không hợp lệ',

            'image.image' => 'Ảnh không được để trống',
            'image.mimes' => 'Ảnh không hợp lệ',
            'image.max' => 'Kích thước tối đa 4096 KB',
        ];
    }
}
