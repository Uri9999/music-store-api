<?php

namespace App\Http\Requests\ReviewTab;

use Illuminate\Foundation\Http\FormRequest;

class ReviewTabStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tab_id' => 'required|exists:tabs,id',
            'rating' => 'required|min:1|max:5',
            'comment' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'tab_id.required' => 'Tab không được để trống',
            'tab_id.exists' => 'Tab không tồn tại',

            'rating.required' => 'Đánh giá không được để trống',
            'rating.min' => 'Tối thiểu 1',
            'rating.max' => 'Tối đa 5',

            'comment.required' => 'Bình luận không được để trống',
            'comment.string' => 'Bình luận không hợp lệ',
        ];
    }
}
