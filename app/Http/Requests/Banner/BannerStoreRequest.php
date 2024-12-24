<?php

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;

class BannerStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.string' => 'Tên không hợp lệ',
            'name.max' => 'Tên tối đa 255 ký tự',

            'description.string' => 'Mô tả không hợp lệ',

            'image.required' => 'Ảnh không được để trống',
            'image.image' => 'Ảnh không hợp lệ',
            'image.mimes' => 'Ảnh không hợp lệ',
            'image.max' => 'Kích thước tối đa 4096 KB',
        ];
    }
}
