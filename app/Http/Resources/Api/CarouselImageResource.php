<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarouselImageResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image_url ? asset('storage/' . $this->image_url) : null,
            'image_url' => $this->image_url,
            'link_url' => $this->link_url,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
            'is_active' => $this->status === 'active',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
