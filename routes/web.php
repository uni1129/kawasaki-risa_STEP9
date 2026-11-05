<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MypageController;


// トップページ（商品一覧）
Route::get('/', [ItemController::class, 'index'])->name('home');

// サンプル・アプリ画面
Route::get('/sample', [SampleController::class, 'showSample']);
Route::get('/app', [AppController::class, 'showApp'])->name('app');

// 認証関連（ログイン・新規登録）
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// お問い合わせフォーム
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');


// ログイン必須のルート
Route::middleware(['auth'])->group(function () {
    // ログアウト
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- マイページ・アカウント関連 ---
    Route::get('/my_page', [MypageController::class, 'index'])->name('mypage');
    Route::get('/mypage/account/edit', [MypageController::class, 'editAccount'])->name('account.edit');
    Route::put('/mypage/account', [MypageController::class, 'updateAccount'])->name('account.update');

    // --- 商品の新規登録関連（固定パスは必ず {id} より上に配置！） ---
    Route::get('/items/create', [MypageController::class, 'createItem'])->name('item.create');
    Route::post('/items/store', [ItemController::class, 'store'])->name('item.store');

    // --- 出品商品管理関連 ---
    Route::get('/mypage/item/{id}', [MypageController::class, 'showItem'])->name('exhibition.item.detail');
    Route::get('/mypage/item/{id}/edit', [MypageController::class, 'editItem'])->name('item.edit');
    Route::delete('/mypage/item/{id}', [MypageController::class, 'destroy'])->name('item.destroy');

    // --- 購入関連 ---
    Route::get('/item/{id}/buy', [ItemController::class, 'buy'])->name('item.buy');
    Route::post('/item/{id}/buy', [ItemController::class, 'purchase'])->name('item.purchase');

    // --- 更新処理（{id} を含むルート） ---
    Route::put('/items/{id}', [ItemController::class, 'update'])->name('item.update');
});


// 固定パスの商品詳細
Route::get('/items/{id}', [ItemController::class, 'show'])->name('item.show');
Route::get('/item/{id}', [ItemController::class, 'show'])->name('item.detail');