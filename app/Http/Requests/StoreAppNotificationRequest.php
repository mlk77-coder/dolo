<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:customers,id'],
            'type' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['pending', 'sent', 'failed'])],
            'sent_at' => ['nullable', 'date'],
        ];
    }
}

