<?php

namespace App\Http\Requests\Notification;

use App\Models\Notification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NotificationIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['array'],
            'status.*' => [Rule::in([Notification::STATUS_SENT, Notification::STATUS_READ])],
            'types' => ['array'],
            'types.*' => [Rule::in([Notification::TYPE_CREATE_ORDER, Notification::TYPE_APPROVE_ORDER, Notification::TYPE_CANCEL_ORDER, Notification::TYPE_REGISTER_SUBSCRIPTION, Notification::TYPE_APPROVE_SUBSCRIPTION, Notification::TYPE_REJECT_ORDER])],
        ];
    }
}
