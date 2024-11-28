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
            'pdf' => 'nullable|max:2048'
        ];
    }
}
