<?php

namespace App\Console\Commands;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Console\Command;

class CleanupGuestShoppingData extends Command
{
    protected $signature = 'shopping:cleanup-guest';

    protected $description = 'Delete expired guest cart and wishlist rows.';

    public function handle(): int
    {
        $now = now();

        $deletedCarts = Cart::query()
            ->whereNull('user_id')
            ->whereNotNull('guest_token')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', $now)
            ->delete();

        $deletedWishlists = Wishlist::query()
            ->whereNull('user_id')
            ->whereNotNull('guest_token')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', $now)
            ->delete();

        $this->info("Deleted {$deletedCarts} guest cart rows and {$deletedWishlists} guest wishlist rows.");

        return self::SUCCESS;
    }
}
