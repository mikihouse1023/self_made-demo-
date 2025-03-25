<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'name',
        'price',
        'quantity',
        'discounted_total',
        'product_id',       // ← 追加
        'product_type',     // ← 追加
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($order) {
            // sales テーブルにコピー
            DB::table('sales')->insert([
                'order_code' => $order->order_code,
                'user_id' => $order->user_id,
                'price' => $order->price,
                'quantity' => $order->quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
}}
