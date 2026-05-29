<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_products' => $this->resource['total_products'],
            'total_orders' => $this->resource['total_orders'],
            'total_customers' => $this->resource['total_customers'],
            'stock_alerts_count' => $this->resource['stock_alerts_count'],
            'recent_orders' => $this->resource['recent_orders'],
        ];
    }
}
