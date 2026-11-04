<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MypageController;

// サンプル
Route::get('/', function () {
    return view('welcome');
});

Route::get('/sample', [SampleController::class, 'showSample']);
Route::get('/app', [AppController::class, 'showApp'])->name('app');

// 未ログインでもアクセスできるルート（ログイン・新規登録）
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// 商品一覧（トップページ）
Route::get('/', [ItemController::class, 'index'])->name('home');

// 商品詳細
Route::get('/items/{id}', [ItemController::class, 'show'])->name('item.show');
Route::get('/item/{id}', [ItemController::class, 'show'])->name('item.detail');

// お問い合わせフォーム
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');





// ログイン必須のルート（要認証）

Route::middleware(['auth'])->group(function () {
    // ログアウト
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 商品の新規登録
    Route::get('/items/create', [ItemController::class, 'create'])->name('item.create');
    Route::post('/items', [ItemController::class, 'store'])->name('item.store');

    Route::get('/items/{id}', [ItemController::class, 'show'])->name('item.show');

    // マイページ関連
    Route::get('/my_page', [MypageController::class, 'index'])->name('mypage');
    Route::get('/mypage/account/edit', [MypageController::class, 'editAccount'])->name('account.edit');

    // アカウント情報の更新処理用
    Route::put('/mypage/account', [MypageController::class, 'updateAccount'])->name('account.update');

    // 出品商品の詳細・編集・更新・削除
    Route::get('/mypage/item/{id}', [MypageController::class, 'showItem'])->name('exhibition.item.detail');
    Route::get('/mypage/item/{id}/edit', [MypageController::class, 'editItem'])->name('item.edit');
    Route::put('/items/{id}', [ItemController::class, 'update'])->name('item.update');
    Route::delete('/mypage/item/{id}', [MypageController::class, 'destroy'])->name('item.destroy');

    // 購入確認画面の表示用（必要に応じて）
    Route::get('/item/{id}/buy', [ItemController::class, 'buy'])->name('item.buy');

    // ★ 購入処理を実行するルート（ここを追加）
    Route::post('/item/{id}/buy', [ItemController::class, 'purchase'])->name('item.purchase');
});
