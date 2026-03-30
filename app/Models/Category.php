<?php

namespace App\Models;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Category extends Model
{
     use HasFactory;

    protected $fillable = ['name', 'slug', 'department_id'];

    // Automatically generate slug when creating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, SubCategory::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }
}
