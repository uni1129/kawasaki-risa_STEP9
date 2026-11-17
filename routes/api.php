<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

// 認証用ルート
Route::post('/login', [AuthController::class, 'Login']);

// 認証が必要なルート（auth:sanctumミドルウェアで保護）
Route::middleware('auth:sanctum')->group(function () {
    // 商品ID付きの購入APIルートを追加
    Route::post('/products/{id}/buy', [ProductController::class, 'purchase']);
});