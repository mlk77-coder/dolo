<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerProfileResource extends JsonResource
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
            'name' => $this->name,
            'surname' => $this->surname,
            'full_name' => trim($this->name . ' ' . $this->surname),
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
            'gender' => $this->gender,
            'avatar' => $this->avatar ? asset('storage/' . $this->avatar) : null,
            'is_admin' => $this->is_admin,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_at_human' => $this->created_at->diffForHumans(),
            
            // Order statistics
            'orders_count' => $this->orders->count(),
            'total_orders' => $this->orders->count(),
            
            // Order history (last 10 orders)
            'order_history' => OrderHistoryResource::collection($this->orders->take(10)),
            
            // Latest order
            'latest_order' => $this->orders->first() ? new OrderHistoryResource($this->orders->first()) : null,
        ];
    }
}
