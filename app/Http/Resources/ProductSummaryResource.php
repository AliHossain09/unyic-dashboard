<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductSummaryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'brand' => $this->brand ?? 'Unknown',
            'images' => $this->images->map(function ($image) {
                if (! $image->image || ! Storage::disk('public')->exists($image->image)) {
                    return null;
                }

                return [
                    'url' => asset('storage/'.$image->image),
                    'isDefault' => (int) $image->is_default,
                ];
            })->filter()->values()->toArray(),
            'sizes' => $this->sizes->map(function ($size) {
                return [
                    'size' => $size->name,
                    'quantity' => $size->pivot->quantity,
                ];
            })->values()->toArray(),
            'price' => [
                'sellingPrice' => (float) $this->price,
                'originalPrice' => (float) $this->old_price,
                'discountPercent' => (int) $this->discount_percent,
            ],
        ];
    }
}
