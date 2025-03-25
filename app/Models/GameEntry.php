<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameEntry extends Model
{
    use HasFactory;
    // 一括代入を許可するカラム
    protected $fillable = [
        'order_code',
        'game_code',
        'game_count',
    ];

    // タイムスタンプのカラムを利用する（デフォルトでtrue）
    public $timestamps = true;
}
