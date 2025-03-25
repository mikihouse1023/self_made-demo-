<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'tel',
        'post',
        'address',
        'is_admin',
        'password',
    ];

    protected $casts = [
    /*is_admin フィールドをブール値として扱うため、$casts配列に追加
    ブール値とは、真[true]または偽[false]の2つの値しか持たないデータ型を指す。*/
        'is_admin' => 'boolean', 
    ];

    protected $attributes=[
        /*ブール値のデフォルトをtrue[管理ユーザー]に設定*/
        'is_admin' =>true,
    ];

    //パスワードをハッシュ化して保存
    public function setPasswordAttribute($value){
        $this->attributes['password']=bcrypt($value);
    }
}