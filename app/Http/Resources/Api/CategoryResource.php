<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'slug' => $this->slug,
            'deals_count' => $this->deals_count ?? 0,
            'products_count' => $this->deals_count ?? 0, // Alias for deals_count
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
