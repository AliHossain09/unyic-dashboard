<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FrontendProductCache
{
    private const VERSION_KEY = 'frontend:products:cache_version';

    public static function makeKey(string $prefix, array $query): string
    {
        $normalized = self::normalizeCacheValue($query);
        $version = self::version();

        return $prefix.':v'.$version.':'.md5(json_encode($normalized));
    }

    public static function bump(): void
    {
        try {
            $store = Cache::store('redis');

            if ($store->get(self::VERSION_KEY) === null) {
                $store->forever(self::VERSION_KEY, 1);
            }

            $store->increment(self::VERSION_KEY);
        } catch (\Throwable $e) {
            Log::warning('Redis cache version bump failed', [
                'key' => self::VERSION_KEY,
                'message' => $e->getMessage(),
            ]);
        }
    }

    private static function version(): int
    {
        try {
            return (int) Cache::store('redis')->get(self::VERSION_KEY, 1);
        } catch (\Throwable $e) {
            Log::warning('Redis cache version fallback used', [
                'key' => self::VERSION_KEY,
                'message' => $e->getMessage(),
            ]);

            return 1;
        }
    }

    private static function normalizeCacheValue(mixed $value): mixed
    {
        if (! is_array($value)) {
            return $value;
        }

        ksort($value);

        foreach ($value as $key => $item) {
            $value[$key] = self::normalizeCacheValue($item);
        }

        return $value;
    }
}
