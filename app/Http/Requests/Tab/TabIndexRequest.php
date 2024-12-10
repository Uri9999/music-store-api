<?php

namespace App\Http\Requests\Tab;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TabIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'orderPrice' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
            'orderCreatedAt' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
            'search' => 'nullable|string',
        ];
    }
}
