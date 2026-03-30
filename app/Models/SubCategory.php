<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'category_id'];




    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Automatically generate slug when creating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subCategory) {
            $subCategory->slug = Str::slug($subCategory->name);
        });

        static::updating(function ($subCategory) {
            $subCategory->slug = Str::slug($subCategory->name);
        });
    }
}
