<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'discount',
        'discount_type',
        'min_order_value',
        'max_usage',
        'used_count',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];
}