<?php

namespace App\Http\Requests\Tab;

use Illuminate\Foundation\Http\FormRequest;

class TabRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'youtube_url' => 'nullable|string',
            'images' => 'required|array|max:5',
            'images.*' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:4096',
            'pdf' => 'required|mimes:pdf|max:2048',
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
            'name.required' => 'Tên không được để trống',
            'name.string' => 'Tên không hợp lệ',
            'name.max' => 'Tên tối đa 255 ký tự',

            'description.string' => 'Mô tả không hợp lệ',

            'user_id.required' => 'Người thực hiện không được để trống',
            'user_id.exists' => 'Người thực hiện không tồn tại',

            'author.required' => 'Tác giả không được để trống',
            'author.string' => 'Tác giả không hợp lệ',
            'author.max' => 'Tác giả tối đa 255 ký tự',

            'price.required' => 'Giá không được để trống',
            'price.numeric' => 'Giá không hợp lệ',
            'price.min' => 'Giá tối thiểu 0',

            'category_id.required' => 'Danh mục không được để trống',
            'category_id.exists' => 'Danh mục không tồn tại',

            'youtube_url.string' => 'Đường dẫn không hợp lệ',

            'images.required' => 'Ảnh không được để trống',
            'images.array' => 'Ảnh không hợp lệ',
            'images.max' => 'Tối đa 5 ảnh',
            'images.*.required' => 'Ảnh không được để trống',
            'images.*.image' => 'Ảnh không hợp lệ',
            'images.*.mimes' => 'Ảnh không hợp lệ',
            'images.*.max' => 'Kích thước tối đa 4096 KB',

            'pdf.required' => 'File Không được để trống',
            'pdf.mimes' => 'File phải là PDF',
            'pdf.max' => 'Kích thước tối đa 2048 KB',

            'discount_money.numeric' => 'Giá trị không hợp lệ',
            'discount_money.min' => 'Giá trị không được nhỏ hơn 0',
        ];
    }
}
