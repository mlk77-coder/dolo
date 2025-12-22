<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_en' => ['required', 'string', 'max:255', 'unique:categories,name_en'],
            'name_ar' => ['required', 'string', 'max:255', 'unique:categories,name_ar'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'icon' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->slug === null && $this->name_en !== null) {
            $this->merge([
                'slug' => Str::slug($this->name_en),
            ]);
        }
    }
}
