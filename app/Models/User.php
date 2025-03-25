<?php

namespace App\Models;
/*↓Laravelで認証機能を実装する際に必須*/
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//ModelからAuthenticatableに変更し、Userモデルを認証可能なモデルとして動作させる
class User extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'stamps',
        'tel',
        'post',
        'address',
        'is_admin', // ここに追加されていることを確認
        'password',
    ];

    protected $casts = [
    /*is_admin フィールドをブール値として扱うため、$casts配列に追加
    ブール値とは、真[true]または偽[false]の2つの値しか持たないデータ型を指す。*/
        'is_admin' => 'boolean', 
    ];

    protected $attributes=[
        /*ブール値のデフォルトをfalse[一般ユーザー]に設定*/
        'is_admin' =>false,
    ];

    //パスワードをハッシュ化して保存
    public function setPasswordAttribute($value){
        $this->attributes['password']=bcrypt($value);
    }
}