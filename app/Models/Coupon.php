<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'discount_type',
        'discount_value',
        'expires_at',
        'used',
        'used_at'
    ];

    public static function generateCode()
    {
        return strtoupper(Str::random(10));
    }
}
