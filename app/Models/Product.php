<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'val',
        'explanation',
        'picture',
        'category',
    ];
}
