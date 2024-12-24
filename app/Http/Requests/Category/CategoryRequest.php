<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.string' => 'Tên không hợp lệ',
            'name.max' => 'Tên tối đa 255 ký tự',

            'description.string' => 'Mô tả không hợp lệ',

            'parent_id.exists' => 'Danh mục cha không tồn tại',
        ];
    }
}
