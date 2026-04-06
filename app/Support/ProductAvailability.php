<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Support\Facades\Schema;

class ProductAvailability
{
    public static function fromProduct(?Product $product): array
    {
        if (! $product) {
            return [
                'is_available' => false,
                'stock_status' => 'unavailable',
                'can_checkout' => false,
            ];
        }

        if (Schema::hasColumn('products', 'is_in_stock')) {
            $isAvailable = (bool) $product->is_in_stock;
        } elseif (method_exists($product, 'sizes')) {
            $isAvailable = $product->relationLoaded('sizes')
                ? $product->sizes->contains(fn ($size) => (int) $size->pivot->quantity > 0)
                : $product->sizes()->wherePivot('quantity', '>', 0)->exists();
        } else {
            $isAvailable = true;
        }

        return [
            'is_available' => $isAvailable,
            'stock_status' => $isAvailable ? 'in_stock' : 'out_of_stock',
            'can_checkout' => $isAvailable,
        ];
    }
}
