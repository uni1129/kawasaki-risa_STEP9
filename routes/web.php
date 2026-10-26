<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;


// ログイン・新規登録・ログアウト
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 商品一覧 (トップページ)
Route::get('/', [ItemController::class, 'index'])->name('item.index');

// 商品詳細
Route::get('/item/{id}', [ItemController::class, 'show'])->name('item.detail');

// 購入画面・購入処理
Route::get('/item/{id}/buy', [ItemController::class, 'buy'])->name('item.buy');
Route::post('/item/{id}/buy', [ItemController::class, 'purchase'])->name('item.purchase');

//商品新規登録 (出品)
Route::get('/item/create', [ItemController::class, 'create'])->name('item.create');
Route::post('/item/store', [ItemController::class, 'store'])->name('item.store');

//出品商品詳細 & 削除
Route::get('/exhibition/{id}', [ItemController::class, 'showExhibition'])->name('exhibition.detail');
Route::delete('/exhibition/{id}', [ItemController::class, 'destroy'])->name('exhibition.destroy');

// 商品編集
Route::get('/item/{id}/edit', [ItemController::class, 'edit'])->name('item.edit');
Route::put('/item/{id}', [ItemController::class, 'update'])->name('item.update');

// マイページ
Route::get('/mypage', [UserController::class, 'index'])->name('mypage.index');

// アカウント編集
Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');

//お問い合わせ
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
