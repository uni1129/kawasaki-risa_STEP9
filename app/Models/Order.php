<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // 一括保存を許可するカラム
    protected $fillable = [
        'user_id',
        'item_id',
        'price',
    ];


    //  購入したユーザー（Userモデルとのリレーション）

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    //  購入された商品（Itemモデルとのリレーション）

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}