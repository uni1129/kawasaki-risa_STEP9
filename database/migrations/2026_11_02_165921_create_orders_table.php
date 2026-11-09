<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // users テーブル
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_kanji');
            $table->string('name_kana')->nullable(); 
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('company_id')->nullable(); 
            $table->rememberToken();
            $table->timestamps();
        });

        // products テーブル
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('company_id');
            $table->string('product_name');
            $table->integer('price');
            $table->integer('stock');
            $table->string('description');
            $table->string('img_path');
            $table->timestamps();
        });

        // sales テーブル
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->timestamps();
        });

        // お気に入り
        Schema::create('likes', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('users');
        Schema::dropIfExists('likes');
    }
};