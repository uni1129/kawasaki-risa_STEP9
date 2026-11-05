<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // 一括保存を許可するカラム
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'image',
        'stock',
    ];


    //  出品者（Userモデルとのリレーション）

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    //  この商品へのお気に入り一覧

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }


    // ユーザーがこの商品をお気に入り登録しているか判定するメソッド

    public function isFavoritedBy($user)
    {
        if (!$user) {
            return false;
        }

        return $this->favorites()->where('user_id', $user->id)->exists();
    }
}