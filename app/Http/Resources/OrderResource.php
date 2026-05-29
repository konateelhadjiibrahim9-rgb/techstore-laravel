<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'order_number' => $this->resource->order_number,
            'user_id' => $this->resource->user_id,
            'total_amount' => (float) $this->resource->total_amount,
            'status' => $this->resource->status,
            'shipping_address' => $this->resource->shipping_address,
            'shipping_city' => $this->resource->shipping_city,
            'shipping_phone' => $this->resource->shipping_phone,
            'payment_method' => $this->resource->payment_method,
            'notes' => $this->resource->notes,
            'items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'created_at' => $this->resource->created_at->toISOString(),
            'updated_at' => $this->resource->updated_at->toISOString(),
        ];
    }
}
