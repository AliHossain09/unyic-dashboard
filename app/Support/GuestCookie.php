<?php

namespace App\Support;

use Symfony\Component\HttpFoundation\Cookie;

class GuestCookie
{
    public const NAME = 'guest_token';

    public const LIFETIME_MINUTES = 60 * 24 * 7;

    public static function make(string $token): Cookie
    {
        return cookie(
            self::NAME,
            $token,
            self::LIFETIME_MINUTES,
            '/',
            null,
            app()->environment('production'),
            true,
            false,
            'Lax'
        );
    }

    public static function forget(): Cookie
    {
        return cookie(
            self::NAME,
            null,
            -1,
            '/',
            null,
            app()->environment('production'),
            true,
            false,
            'Lax'
        );
    }
}
