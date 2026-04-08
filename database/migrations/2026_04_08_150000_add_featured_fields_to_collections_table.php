<?php

use App\Models\Collection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
            $table->string('brand')->nullable()->after('description');
            $table->string('short_description')->nullable()->after('brand');
            $table->boolean('is_featured')->default(true)->after('short_description');
        });

        Collection::query()->get()->each(function ($collection) {
            $baseSlug = Str::slug($collection->title ?: 'collection');
            $slug = $baseSlug;
            $counter = 1;

            while (Collection::where('slug', $slug)->where('id', '!=', $collection->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $collection->updateQuietly([
                'slug' => $slug,
                'short_description' => $collection->description,
                'is_featured' => true,
            ]);
        });

        Schema::table('collections', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'brand', 'short_description', 'is_featured']);
        });
    }
};
