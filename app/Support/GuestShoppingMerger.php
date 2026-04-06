<?php

namespace App\Support;

use App\Models\Cart;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;

class GuestShoppingMerger
{
    public static function mergeIntoUserFromToken(?string $guestToken, User $user): bool
    {
        if (! is_string($guestToken) || $guestToken === '') {
            return false;
        }

        $hasMerged = false;

        DB::transaction(function () use ($guestToken, $user, &$hasMerged) {
            $guestCartItems = Cart::query()
                ->whereNull('user_id')
                ->where('guest_token', $guestToken)
                ->get();

            foreach ($guestCartItems as $guestCartItem) {
                $existingCartItem = Cart::query()
                    ->where('user_id', $user->id)
                    ->where('product_id', $guestCartItem->product_id)
                    ->where('size', $guestCartItem->size)
                    ->first();

                if ($existingCartItem) {
                    $existingCartItem->quantity += $guestCartItem->quantity;
                    $existingCartItem->save();
                    $guestCartItem->delete();
                } else {
                    $guestCartItem->user_id = $user->id;
                    $guestCartItem->guest_token = null;
                    $guestCartItem->expires_at = null;
                    $guestCartItem->last_activity_at = null;
                    $guestCartItem->save();
                }

                $hasMerged = true;
            }

            $guestWishlistItems = Wishlist::query()
                ->whereNull('user_id')
                ->where('guest_token', $guestToken)
                ->get();

            foreach ($guestWishlistItems as $guestWishlistItem) {
                $existingWishlistItem = Wishlist::query()
                    ->where('user_id', $user->id)
                    ->where('product_id', $guestWishlistItem->product_id)
                    ->first();

                if ($existingWishlistItem) {
                    $guestWishlistItem->delete();
                } else {
                    $guestWishlistItem->user_id = $user->id;
                    $guestWishlistItem->guest_token = null;
                    $guestWishlistItem->expires_at = null;
                    $guestWishlistItem->last_activity_at = null;
                    $guestWishlistItem->save();
                }

                $hasMerged = true;
            }

            Cart::query()
                ->whereNull('user_id')
                ->where('guest_token', $guestToken)
                ->delete();

            Wishlist::query()
                ->whereNull('user_id')
                ->where('guest_token', $guestToken)
                ->delete();
        });

        return $hasMerged;
    }
}
