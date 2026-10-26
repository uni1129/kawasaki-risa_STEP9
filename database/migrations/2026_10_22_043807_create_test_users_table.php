<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('kanji_name')->after('name'); // 名前（漢字）
        $table->string('kana_name')->after('kanji_name'); // 名前（カナ）
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['kanji_name', 'kana_name']);
    });
}
};
