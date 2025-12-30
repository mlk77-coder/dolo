<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'merchant_id' => ['nullable', 'integer', 'min:1'],
            'category_id' => ['nullable', 'integer', 'min:1'],
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:255'],
            'original_price' => ['required', 'numeric', 'min:0'],
            'discounted_price' => ['required', 'numeric', 'min:0', 'lte:original_price'],
            'discount_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'buyer_counter' => ['nullable', 'integer', 'min:0'],
            'show_buyer_counter' => ['boolean'],
            'show_savings_percentage' => ['boolean'],
            'description' => ['nullable', 'string'],
            'deal_information' => ['nullable', 'string'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'video' => ['nullable', 'file', 'mimes:mp4,avi,mov,wmv,flv,webm', 'max:10240'], // 10MB max
            'city' => ['nullable', 'string', 'max:255'],
            'area' => ['nullable', 'string', 'max:255'],
            'location_name' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'status' => ['required', Rule::in(['draft', 'active', 'inactive', 'expired'])],
            'featured' => ['boolean'],
        ];
    }
}

