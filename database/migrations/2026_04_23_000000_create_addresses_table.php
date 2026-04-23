<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('addresses')) {
            return;
        }

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('guest_token', 100)->nullable()->index();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 30);
            $table->text('address');
            $table->string('address_type', 50);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_selected')->default(false);
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('addresses')) {
            Schema::dropIfExists('addresses');
        }
    }
};
