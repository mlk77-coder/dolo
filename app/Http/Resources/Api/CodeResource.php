<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CodeResource extends JsonResource
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
            'subject' => $this->subject,
            'code' => $this->code,
            'discount_amount' => (float) $this->discount_amount,
            'discount_formatted' => '$' . number_format($this->discount_amount, 2),
            'valid_to' => $this->valid_to?->format('Y-m-d'),
            'valid_to_formatted' => $this->valid_to?->format('M d, Y'),
            'is_expired' => $this->valid_to ? $this->valid_to->isPast() : false,
            'is_active' => $this->is_active,
            'status' => $this->is_active ? 'active' : 'inactive',
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'image_url' => $this->image,
            'external_url' => $this->external_url,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
