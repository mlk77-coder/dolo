<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')->id ?? null;

        return [
            'name_en' => ['required', 'string', 'max:255', Rule::unique('categories', 'name_en')->ignore($categoryId)],
            'name_ar' => ['required', 'string', 'max:255', Rule::unique('categories', 'name_ar')->ignore($categoryId)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($categoryId)],
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
