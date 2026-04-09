<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SpotlightBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'slug',
        'image',
        'is_active',
        'serial',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (SpotlightBrand $spotlightBrand) {
            $spotlightBrand->slug = Str::slug($spotlightBrand->brand);
        });
    }
}
