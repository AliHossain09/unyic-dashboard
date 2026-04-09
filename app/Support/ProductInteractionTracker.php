<?php

namespace App\Support;

use App\Models\ProductInteraction;
use Illuminate\Http\Request;

class ProductInteractionTracker
{
    public const TYPE_VIEW = 'view';
    public const TYPE_WISHLIST = 'wishlist';
    public const TYPE_CART = 'cart';

    public static function record(Request $request, int $productId, string $type): array
    {
        $identity = ShoppingIdentity::resolve($request);
        $weight = self::weightFor($type);

        $interaction = ShoppingScope::apply(
            ProductInteraction::query()
                ->where('product_id', $productId)
                ->where('interaction_type', $type),
            $identity
        )->first();

        if ($interaction) {
            $interaction->score = min(50, (int) $interaction->score + $weight);
            $interaction->fill(ShoppingScope::guestActivityPayload($identity));
            $interaction->last_activity_at = now();
            $interaction->save();
        } else {
            ProductInteraction::create([
                'user_id' => $identity['user_id'],
                'guest_token' => $identity['guest_token'],
                'product_id' => $productId,
                'interaction_type' => $type,
                'score' => $weight,
                'last_activity_at' => now(),
                ...ShoppingScope::guestActivityPayload($identity),
            ]);
        }

        return $identity;
    }

    public static function weightFor(string $type): int
    {
        return match ($type) {
            self::TYPE_CART => 5,
            self::TYPE_WISHLIST => 4,
            default => 2,
        };
    }
}
