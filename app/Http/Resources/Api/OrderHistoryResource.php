<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderHistoryResource extends JsonResource
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
            'order_number' => $this->order_number,
            'quantity' => $this->quantity,
            'total_price' => (float) $this->total_price,
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            'qr_code' => $this->qr_code,
            'pin_code' => $this->pin_code,
            'coupon_code' => $this->coupon_code,
            
            // Deal information
            'deal' => $this->when($this->deal, [
                'id' => $this->deal?->id,
                'title_en' => $this->deal?->title_en,
                'title_ar' => $this->deal?->title_ar,
                'original_price' => (float) $this->deal?->original_price,
                'discounted_price' => (float) $this->deal?->discounted_price,
                'discount_percentage' => (float) $this->deal?->discount_percentage,
            ]),
            
            // Merchant information
            'merchant' => $this->when($this->merchant, [
                'id' => $this->merchant?->id,
                'business_name' => $this->merchant?->business_name,
                'contact_email' => $this->merchant?->contact_email,
                'contact_phone' => $this->merchant?->contact_phone,
            ]),
            
            // Timestamps
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_at_human' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
