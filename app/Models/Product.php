<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'category_id', 'slug', 'sub_category_id', 'old_price', 'discount_percent', 'is_popular', 'is_new', 'is_published', 'publish_at', 'is_in_stock', 'views', 'brand', 'collection', 'color', 'disclaimer', 'care_instructions', 'net_quantity', 'manufacture_date', 'country_of_origin'];

    protected $casts = [
        'is_popular' => 'boolean',
        'is_new' => 'boolean',
        'is_published' => 'boolean',
        'publish_at' => 'datetime',
        'is_in_stock' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_product');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }


    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size')
                ->withPivot('quantity')
                ->withTimestamps();
    }
}
