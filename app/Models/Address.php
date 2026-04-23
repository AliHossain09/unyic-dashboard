<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_token',
        'name',
        'email',
        'phone',
        'address',
        'address_type',
        'is_default',
        'is_selected',
        'expires_at',
        'last_activity_at',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_selected' => 'boolean',
        'expires_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
