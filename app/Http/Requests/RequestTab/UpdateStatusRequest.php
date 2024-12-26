<?php

namespace App\Http\Requests\RequestTab;

use App\Models\RequestTab;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([RequestTab::STATUS_DEFAULT, RequestTab::STATUS_PROCESSING, RequestTab::STATUS_COMPLETED])],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Không được để trống',
            'status.in' => 'Không hợp lệ',
        ];
    }
}
