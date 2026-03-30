<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class PopularCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'department_id', 'category_id', 'sub_category_id', 'desktop_image', 'mobile_image'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->slug = Str::slug($item->title);
        });

        static::updating(function ($item) {
            $item->slug = Str::slug($item->title);
        });
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function subCategory() {
        return $this->belongsTo(SubCategory::class);
    }
}
