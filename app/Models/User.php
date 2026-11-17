<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'name_kanji',
        'name_kana',
        'email',
        'password',
        'company_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
