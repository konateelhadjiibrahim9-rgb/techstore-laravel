<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteItemResource extends JsonResource
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
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'price' => (int) $this->product->price,
            ],
            'quantity' => (int) $this->quantity,
            'unit_price' => (int) $this->unit_price,
            'subtotal' => (int) $this->subtotal,
        ];
    }
}
