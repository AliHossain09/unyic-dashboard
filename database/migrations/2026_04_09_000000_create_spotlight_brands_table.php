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
        Schema::create('spotlight_brands', function (Blueprint $table) {
            $table->id();
            $table->string('brand')->unique();
            $table->string('slug')->unique();
            $table->string('image');
            $table->unsignedInteger('serial')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spotlight_brands');
    }
};
