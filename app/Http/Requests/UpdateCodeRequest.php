<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', Rule::unique('codes', 'code')->ignore($this->code)],
            'discount_amount' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'valid_to' => ['nullable', 'date', 'after_or_equal:today'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'external_url' => ['nullable', 'url', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'Subject is required',
            'code.required' => 'Code is required',
            'code.unique' => 'This code already exists',
            'discount_amount.required' => 'Discount amount is required',
            'discount_amount.numeric' => 'Discount amount must be a number',
            'discount_amount.min' => 'Discount amount must be at least 0',
            'valid_to.date' => 'Valid to must be a valid date',
            'valid_to.after_or_equal' => 'Valid to date must be today or a future date',
            'image.image' => 'File must be an image',
            'image.max' => 'Image size must not exceed 2MB',
        ];
    }
}
