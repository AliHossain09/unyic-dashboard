<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'size' => $this->size,
            'quantity' => $this->quantity,
            'product' => new ProductSummaryResource($this->whenLoaded('product')),
        ];
    }
}
