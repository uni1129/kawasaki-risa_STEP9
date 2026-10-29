<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    // 一括保存を許可するカラムを指定
    protected $fillable = [
        'user_id',
        'item_id',
    ];


    //  お気に入りを所有するユーザー（Userモデルとのリレーション）

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //  お気に入り対象の商品（Itemモデルとのリレーション）
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}