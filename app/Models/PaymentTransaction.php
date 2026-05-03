<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'order_id',
        'tran_id',
        'val_id',
        'bank_tran_id',
        'amount',
        'currency',
        'card_type',
        'card_issuer',
        'card_brand',
        'card_category',
        'status',
        'risk_level',
        'risk_title',
        'gateway_response',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
    ];
}
