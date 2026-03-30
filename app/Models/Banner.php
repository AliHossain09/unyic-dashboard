<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //  protected $fillable = ['title', 'slug', 'sub_category_id', 'banner_desktop_image', 'banner_mobile_image'];

     protected $fillable = [
        'title',
        'slug',
        'sub_category_id',
        'banner_desktop_image',
        'banner_mobile_image',
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    // Custom API format
    public function toArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'link' => url('/sub-category/' . $this->subCategory->slug),
            'images' => [
                'desktop' => $this->banner_desktop_image ? asset('storage/' . $this->banner_desktop_image) : null,
                'mobile'  => $this->banner_mobile_image ? asset('storage/' . $this->banner_mobile_image) : null,
            ],
            'slug' => $this->slug, // hover করার জন্য
        ];
    }
}
