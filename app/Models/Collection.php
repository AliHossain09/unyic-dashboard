<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Collection extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'brand',
        'short_description',
        'banner_image',
        'is_featured',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($collection) {
            $collection->slug = static::generateUniqueSlug($collection->title);
        });

        static::updating(function ($collection) {
            if ($collection->isDirty('title')) {
                $collection->slug = static::generateUniqueSlug($collection->title, $collection->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title ?: 'collection');
        $slug = $baseSlug;
        $counter = 1;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'collection_product');
    }
}
