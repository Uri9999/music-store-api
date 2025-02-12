<?php

namespace App\Http\Requests\Tab;

use Illuminate\Foundation\Http\FormRequest;

class TabUpdateRequest extends FormRequest
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
            'user_id' => 'exists:users,id',
            'author' => 'string|max:255',
            'price' => 'numeric|min:0',
            'category_id' => 'exists:categories,id',
            'youtube_url' => 'nullable|string',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:4096',
            'pdf' => 'nullable|mimes:pdf|max:2048',
            'discount_money' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($this->get('price') < $value) {
                        $fail('Giá khuyến mãi không thể nhỏ hơn giá gốc');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Tên không được để trống',
            'name.max' => 'Tên tối đa 255 ký tự',

            'description.string' => 'Mô tả không hợp lệ',

            'user_id.exists' => 'Người thực hiện không tồn tại',

            'author.string' => 'Tác giả không được để trống',
            'author.max' => 'Tác giả tối đa 255 ký tự',

            'price.numeric' => 'Giá không hợp lệ',
            'price.min' => 'Giá trị không được nhỏ hơn 0',

            'category_id.exists' => 'Danh mục không tồn tại',

            'youtube_url.string' => 'Đường dẫn không hợp lệ',

            'images.array' => 'Ảnh không hợp lệ',
            'images.max' => 'Tối đa 5 ảnh',
            'images.*.image' => 'Ảnh không hợp lệ',
            'images.*.mimes' => 'Ảnh không hợp lệ',
            'images.*.max' => 'Kích thước tối đa 4096 KB',

            'pdf.mimes' => 'File phải là PDF',
            'pdf.max' => 'Kích thước tối đa 2048 KB',

            'discount_money.numeric' => 'Giá trị không hợp lệ',
            'discount_money.min' => 'Giá trị không được nhỏ hơn 0',
        ];
    }
}
