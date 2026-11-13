<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Product extends Model
{
    use HasFactory;

    // 一括保存を許可するカラム
    protected $fillable = [
        'user_id',
        'company_id',
        'product_name',
        'description',
        'price',
        'img_path',
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


    // likesテーブルとのリレーション
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // ログインユーザーがこの商品をお気に入り登録しているか判定
    public function isLikedBy($user)
    {
        if (!$user) {
            return false;
        }
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
