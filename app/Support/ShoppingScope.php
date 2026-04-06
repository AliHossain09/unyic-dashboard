<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ShoppingScope
{
    public static function apply(Builder $query, array $identity): Builder
    {
        if ($identity['type'] === 'user') {
            return $query->where('user_id', $identity['user_id']);
        }

        return $query
            ->whereNull('user_id')
            ->where('guest_token', $identity['guest_token'])
            ->where(function (Builder $builder) {
                $builder->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            });
    }

    public static function guestActivityPayload(array $identity): array
    {
        if ($identity['type'] !== 'guest') {
            return [];
        }

        return [
            'last_activity_at' => now(),
            'expires_at' => now()->addDays(7),
        ];
    }

    public static function touchGuestItems(string $modelClass, array $identity): void
    {
        if ($identity['type'] !== 'guest') {
            return;
        }

        /** @var Model $modelClass */
        $modelClass::query()
            ->whereNull('user_id')
            ->where('guest_token', $identity['guest_token'])
            ->update(self::guestActivityPayload($identity));
    }
}
