<?php

namespace App\Http\Requests\ReviewTab;

use Illuminate\Foundation\Http\FormRequest;

class ReviewTabIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => 'bail|nullable|string',
        ];
    }
}
