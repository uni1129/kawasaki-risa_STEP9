<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // 出品者のID
            $table->string('product_name');                          // 商品名
            $table->integer('price');                        // 価格
            $table->text('description');                     // 商品説明（text型なので文章が入れられます）
            $table->string('image')->nullable();             // 画像パス（未選択でもエラーにならないようnullable）
            $table->integer('stock')->default(0);            // 在庫数
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};