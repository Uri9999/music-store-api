<?php

namespace App\Http\Requests\Article;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => ['required', Rule::in([Article::STATUS_DRAFT, Article::STATUS_PUBLIC, Article::STATUS_LOCK])],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề không được để trống',
            'title.string' => 'Tiêu đề không hợp lệ',
            'title.max' => 'Tiêu đề tối đa 255 ký tự',

            'content.required' => 'Nội dung không được để trống',
            'content.string' => 'Nội dung không hợp lệ',

            'status.required' => 'Trạng thái không được để trống',
            'status.in' => 'Trạng thái không hợp lệ',
        ];
    }
}
