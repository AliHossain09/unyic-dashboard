<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('guest_token', 100)->nullable()->index();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('interaction_type', 50)->index();
            $table->unsignedInteger('score')->default(1);
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamp('last_activity_at')->nullable()->index();
            $table->timestamps();

            $table->index(['user_id', 'interaction_type']);
            $table->index(['product_id', 'interaction_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_interactions');
    }
};
