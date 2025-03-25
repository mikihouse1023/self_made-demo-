<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'item_id', 'category', 'name', 'price', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
