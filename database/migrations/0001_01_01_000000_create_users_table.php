<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();                                    // ID 
            $table->string('name');                          // ユーザ名
            $table->string('name_kanji');                    // 漢字名
            $table->string('name_kana')->nullable();         // カナ名 
            $table->string('email')->unique();               // メールアドレス
            $table->string('password');                      // パスワード
            $table->foreignId('company_id')->nullable()->constrained('companies'); // 会社ID
            $table->timestamps();                            // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};