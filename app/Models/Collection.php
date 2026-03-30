<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
     protected $fillable = ['title', 'description', 'banner_image'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'collection_product');
    }
}
