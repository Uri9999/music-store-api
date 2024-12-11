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
}
