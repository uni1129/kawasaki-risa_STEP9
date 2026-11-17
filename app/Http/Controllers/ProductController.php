<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Like;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
  // 検索バー
  public function index(Request $request)
  {
    $keyword = $request->input('keyword');
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');

    $query = Product::query();

    if (Auth::check()) {
      $query->where('user_id', '!=', Auth::id());
    }

    // 商品名検索
    if (!empty($keyword)) {
      $query->where('product_name', 'LIKE', "%{$keyword}%");
    }

    // 最低価格の絞り込み
    if (!empty($minPrice)) {
      $query->where('price', '>=', $minPrice);
    }

    // 最高価格の絞り込み
    if (!empty($maxPrice)) {
      $query->where('price', '<=', $maxPrice);
    }

    $products = $query->get();

    return view('index', compact('products'));
  }


  // 商品新規登録画面を表示するメソッド
  public function create()
  {
    return view('product_create');
  }


  // 新規登録データをデータベースに保存するメソッド

  public function store(Request $request)
  {
    // バリデーション
    $request->validate([
      'product_name' => 'required|string|max:255',
      'price' => 'required|integer|min:0',
      'stock' => 'required|integer|min:0',
      'description' => 'nullable|string',
      'img_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $img_pathPath = null;

    // 画像がアップロードされた場合の処理
    if ($request->hasFile('img_path')) {
      $file = $request->file('img_path');
      $filename = time() . '_' . $file->getClientOriginalName();

      // public/products フォルダに保存する場合
      $file->move(public_path('products'), $filename);
      $img_pathPath = 'products/' . $filename;
    }


    // ログインユーザーの取得と company_id のフォールバック
    $user = Auth::user();
    $companyId = $user->company_id ?? 1;

    // 商品データをデータベースに保存
    Product::create([
      'user_id'      => $user->id,
      'company_id'   => $companyId,
      'product_name' => $request->product_name,
      'price'        => $request->price,
      'stock'        => $request->stock,
      'description'  => $request->description,
      'img_path'     => $img_pathPath,
    ]);

    return redirect()->route('mypage')->with('success', '商品を登録しました！');
  }


  // 商品詳細画面表示
  public function show($id)
  {
    $product = Product::findOrFail($id);
    return view('exhibition_product_detail', compact('product'));
  }


  // 購入確認画面表示
  public function confirm($id)
  {
    $product = Product::findOrFail($id);
    return view('product_buy', compact('product'));
  }



  public function buy($id)
  {
    // 商品データを取得して購入画面（buyビュー）へ渡す
    $product = Product::findOrFail($id);

    return view('buy', compact('product'));
  }


  // 購入処理（API用としてJSONを返す）
  public function purchase(Request $request, $id) // ← $id を受け取るようにする
  {
    $request->validate([
      'quantity' => 'required|integer|min:1',
    ]);

    // URLの {id} を商品IDとして使う
    $product = Product::find($id);

    if (!$product) {
      return response()->json(['message' => '商品が見つかりません。'], 404);
    }

    if ($product->stock < $request->input('quantity')) {
      return response()->json(['message' => '在庫が不足しています。'], 400);
    }

    DB::beginTransaction();
    try {
      $sale = Sale::create([
        'user_id' => Auth::id(),
        'product_id' => $id,
        'quantity' => $request->input('quantity'),
      ]);

      $product->decrement('stock', $request->input('quantity'));

      DB::commit();

      return response()->json([
        'success' => true,
        'message' => '購入が完了しました',
        'redirect_url' => route('home')
      ], 200);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['message' => '購入処理に失敗しました'], 500);
    }
  }


  // 編集画面を表示
  public function edit($id)
  {
    $product = Product::findOrFail($id);

    if ($product->user_id !== Auth::id()) {
      return redirect()->route('mypage')->with('error', '権限がありません。');
    }

    // editメソッドは本来の編集画面（ビュー）を返すように戻す
    return view('product.edit', compact('product'));
  }

  // 商品情報を更新
  public function update(Request $request, $id)
  {
    $product = Product::findOrFail($id);

    $product->update($request->all());

    $request->validate([
      'product_name' => 'required|string|max:255',
      'price' => 'required|integer|min:0',
      'description' => 'required|string',
      'stock' => 'required|integer|min:0',
      'img_path' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $img_pathPath = $product->img_path;

    if ($request->hasFile('img_path')) {
      $img_path = $request->file('img_path');
      $filename = time() . '_' . $img_path->getClientOriginalName();
      $img_path->move(public_path('products'), $filename);
      $img_pathPath = 'products/' . $filename;
    }

    $product->update([
      'product_name' => $request->product_name,
      'price' => $request->price,
      'description' => $request->description,
      'stock' => $request->stock,
      'img_path' => $img_pathPath,
    ]);

    return redirect()->route('mypage.product.detail', $product->id)
      ->with('success', '商品情報を更新しました。');
  }

  // 商品を削除
  public function destroy($id)
  {
    $product = Product::findOrFail($id);

    if ($product->user_id !== Auth::id()) {
      return redirect()->route('mypage')->with('error', '権限がありません。');
    }

    $product->delete();

    return redirect()->route('mypage')->with('success', '商品を削除しました！');
  }


  public function like(Product $product)
  {
    $user = Auth::user();

    if (!$user) {
      return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    $like = Like::where('user_id', $user->id)
      ->where('product_id', $product->id)
      ->first();

    if ($like) {
      $like->delete();
      $liked = false;
    } else {
      Like::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
      ]);
      $liked = true;
    }

    return response()->json(['liked' => $liked]);
  }
}
