<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            if (! Schema::hasColumn('carts', 'guest_token')) {
                $table->string('guest_token', 100)->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('carts', 'expires_at')) {
                $table->timestamp('expires_at')->nullable()->after('size');
            }

            if (! Schema::hasColumn('carts', 'last_activity_at')) {
                $table->timestamp('last_activity_at')->nullable()->after('expires_at');
            }

            if (Schema::hasColumn('carts', 'size')) {
                $table->string('size')->nullable()->change();
            }

            $table->foreignId('user_id')->nullable()->change();
        });

        Schema::table('wishlists', function (Blueprint $table) {
            if (! Schema::hasColumn('wishlists', 'guest_token')) {
                $table->string('guest_token', 100)->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('wishlists', 'expires_at')) {
                $table->timestamp('expires_at')->nullable()->after('product_id');
            }

            if (! Schema::hasColumn('wishlists', 'last_activity_at')) {
                $table->timestamp('last_activity_at')->nullable()->after('expires_at');
            }

            $table->foreignId('user_id')->nullable()->change();
        });

        $this->ensureIndex('carts', 'carts_guest_token_index', ['guest_token']);
        $this->ensureIndex('carts', 'carts_expires_at_index', ['expires_at']);
        $this->ensureIndex('wishlists', 'wishlists_guest_token_index', ['guest_token']);
        $this->ensureIndex('wishlists', 'wishlists_expires_at_index', ['expires_at']);
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropIndex('carts_guest_token_index');
            $table->dropIndex('carts_expires_at_index');
        });

        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropIndex('wishlists_guest_token_index');
            $table->dropIndex('wishlists_expires_at_index');
        });
    }

    protected function ensureIndex(string $table, string $indexName, array $columns): void
    {
        $database = DB::getDatabaseName();

        $exists = DB::table('information_schema.statistics')
            ->where('table_schema', $database)
            ->where('table_name', $table)
            ->where('index_name', $indexName)
            ->exists();

        if (! $exists) {
            Schema::table($table, function (Blueprint $blueprint) use ($columns, $indexName) {
                $blueprint->index($columns, $indexName);
            });
        }
    }
};
