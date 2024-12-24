<?php

namespace App\Http\Requests\Media;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|max:4096',
            'collection' => ['required', Rule::in([Article::MEDIA_ARTICLE])],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'File không được để trống',
            'file.max' => 'Kích thước tối đa 4096 KB',

            'collection.required' => 'Bộ sưu tập không được để trống',
            'collection.in' => 'Bộ sưu tập không hợp lệ',
        ];
    }
}
