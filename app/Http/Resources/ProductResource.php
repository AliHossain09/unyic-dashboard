<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    private $hideDetails = false; // default false

    //  এই function allow করবে controller থেকে details লুকাতে
    public function hideDetails()
    {
        $this->hideDetails = true;

        return $this;
    }

    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'images' => $this->images->map(function ($image) {
                if (! $image->image || ! Storage::disk('public')->exists($image->image)) {
                    return null;
                }

                return [
                    'url' => $image->image ? asset('storage/'.$image->image) : null,
                    'isDefault' => (int) $image->is_default,
                ];
            })->filter()->values()->toArray(),
            'sizes' => $this->sizes->map(function ($size) {
                return [
                    'size' => $size->name,
                    'quantity' => $size->pivot->quantity,
                ];
            })->toArray(),
            'price' => [
                'sellingPrice' => (float) $this->price,
                'originalPrice' => (float) $this->old_price,
                'discountPercent' => (int) $this->discount_percent,
            ],
        ];

        //  শুধুমাত্র যদি hideDetails = false হয় তখন যোগ করবো
        if (! $this->hideDetails) {
            $data['details'] = [
                'description' => $this->description,
                'category' => $this->category?->name,
                'brand' => optional($this->brand)->name ?? 'Unknown',
                'collection' => optional($this->collection)->name ?? 'Default Collection',
                'color' => $this->color ?? 'Not specified',
                'disclaimer' => $this->disclaimer ?? 'Color may vary due to lighting.',
                'careInstructions' => $this->care_instructions ?? 'Follow standard washing instructions.',
            ];

            $data['disclosure'] = [
                'mrp' => (float) $this->old_price,
                'netQuantity' => '1 pc',
                'manufactureDate' => optional($this->manufacture_date)->format('F Y') ?? 'N/A',
                'countryOfOrigin' => $this->country_of_origin ?? 'Bangladesh',
            ];
        }

        return $data;
    }
}
