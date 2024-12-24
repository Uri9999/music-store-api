<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StatsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'year' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'year.required' => 'Năm không được để trống',
        ];
    }
}
