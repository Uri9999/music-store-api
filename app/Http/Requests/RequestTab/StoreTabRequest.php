<?php

namespace App\Http\Requests\RequestTab;

use Illuminate\Foundation\Http\FormRequest;

class StoreTabRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.string' => 'Tên không hợp lệ',
            'name.max' => 'Tên tối đa 255 ký tự',

            'author.required' => 'Tác giả không được để trống',
            'author.string' => 'Tác giả không hợp lệ',
            'author.max' => 'Tác giả tối đa 255 ký tự',
        ];
    }
}
