<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MypageController;

// トップページ（商品一覧 ＆ 検索結果）
Route::get('/home', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

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

    // マイページ・アカウント関連（固定パス）
    Route::get('/my_page', [MypageController::class, 'index'])->name('mypage');
    Route::get('/mypage/account/edit', [MypageController::class, 'editAccount'])->name('account.edit');
    Route::put('/mypage/account', [MypageController::class, 'updateAccount'])->name('account.update');

    // 商品の新規登録関連
    Route::get('/product/create', [MypageController::class, 'createProduct'])->name('product.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('product.store');

    // お気に入り登録・解除
    Route::post('/products/{product}/like', [ProductController::class, 'like']);


    // 商品詳細（ログインしていなくても見られる場合）
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.exhibition');



    // 出品商品管理関連（マイページからの詳細・編集・削除）
    Route::get('/mypage/product/{id}', [MypageController::class, 'show'])->name('mypage.product.detail');
    Route::get('/mypage/product/{id}/edit', [MypageController::class, 'edit'])->name('product.edit');
    Route::delete('/mypage/product/{id}', [MypageController::class, 'destroy'])->name('product.destroy');

    // 購入関連
    Route::get('/product/{id}/buy', [ProductController::class, 'buy'])->name('product.buy');
    Route::post('/product/{id}/buy', [ProductController::class, 'purchase'])->name('product.purchase');

    // 商品の更新処理
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');

    // フォーム画面を表示するルート
    Route::get('/products/{id}/contact', [ContactController::class, 'showContactForm'])->name('product.contact.form');

    // メインの送信処理ルート
    Route::post('/products/{id}/contact', [ContactController::class, 'send'])->name('product.contact');
});
