<?php

namespace App\Http\Requests\Article;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'string|max:255',
            'content' => 'string',
            'status' => [Rule::in([Article::STATUS_DRAFT, Article::STATUS_PUBLIC, Article::STATUS_LOCK])],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'Tiêu đề không được để trống',
            'title.max' => 'Tiêu đề tối đa 255 ký tự',

            'content.string' => 'Nội dung không được để trống',

            'status.in' => 'Trạng thái không hợp lệ',
        ];
    }
}
