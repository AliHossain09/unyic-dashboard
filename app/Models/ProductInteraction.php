<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_token',
        'product_id',
        'interaction_type',
        'score',
        'expires_at',
        'last_activity_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
