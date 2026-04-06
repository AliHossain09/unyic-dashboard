<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class ShoppingIdentity
{
    public static function resolve(Request $request): array
    {
        $user = self::resolveAuthenticatedUser($request);

        if ($user) {
            return [
                'type' => 'user',
                'user_id' => $user->id,
                'guest_token' => null,
                'should_set_cookie' => false,
            ];
        }

        $guestToken = $request->cookie(GuestCookie::NAME);
        $shouldSetCookie = false;

        if (! is_string($guestToken) || strlen($guestToken) < 40) {
            $guestToken = Str::random(64);
            $shouldSetCookie = true;
        }

        return [
            'type' => 'guest',
            'user_id' => null,
            'guest_token' => $guestToken,
            'should_set_cookie' => $shouldSetCookie,
        ];
    }

    protected static function resolveAuthenticatedUser(Request $request): ?User
    {
        if ($request->user()) {
            return $request->user();
        }

        $bearerToken = $request->bearerToken();

        if (! $bearerToken) {
            return null;
        }

        $accessToken = PersonalAccessToken::findToken($bearerToken);

        if (! $accessToken || ! $accessToken->tokenable instanceof User) {
            return null;
        }

        return $accessToken->tokenable;
    }
}
