<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRedemptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'user_id' => ['required', 'exists:customers,id'],
            'merchant_id' => ['nullable', 'exists:merchants,id'],
            'redeemed_at' => ['nullable', 'date'],
            'redeemed_by' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['pending', 'completed', 'cancelled'])],
            'notes' => ['nullable', 'string'],
        ];
    }
}

