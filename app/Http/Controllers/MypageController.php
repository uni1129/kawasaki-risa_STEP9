<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Sale;

class MypageController extends Controller
{
    // マイページ表示（自分が出品した商品一覧・購入した商品一覧を取得）
    public function index()
    {
        $user = Auth::user();

        // ログインユーザーが出品した商品（商品番号の昇順）
        $products = Product::where('user_id', $user->id)
            ->orderBy('id', 'asc')
            ->get();

        $sales = Sale::where('user_id', $user->id)
            ->with('product')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('my_page', compact('user', 'products', 'sales'));
    }

    public function editAccount()
    {
        $user = Auth::user();

        return view('account_edit', compact('user'));
    }

    // アカウント情報の更新処理
    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        // 4つの項目に対応したバリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'kanji' => 'required|string|max:255',
            'kana' => 'required|string|max:255',
        ]);

        // それぞれの値代入
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->name_kanji = $request->input('kanji');
        $user->name_kana = $request->input('kana');
        $user->save();

        return redirect()->route('mypage')->with('success', 'アカウント情報を更新しました！');
    }

    // 商品新規登録画面表示
    public function createProduct()
    {
        return view('product_register');
    }

    // 出品商品詳細表示

    public function show($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

        return view('product_detail', compact('product'));
    }

    // 出品商品の削除
    public function destroy($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);


        $product->delete();

        return redirect()->route('mypage')->with('success', '商品を削除しました。');
    }

    // 商品編集画面を表示する
    public function edit($id)
    {
        // ログインユーザーが自分の出品した商品だけを編集できるように取得
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

        // 編集用のビュー（例: product_edit）にデータを渡して表示
        return view('product_edit', compact('product'));
    }


    // 出品商品の更新処理
    public function updateProduct(Request $request, $id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'img_path' => 'nullable|img_path|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        // 新しい画像がアップロードされた場合の処理
        if ($request->hasFile('img_path')) {
            $img_path = $request->file('img_path');
            $filename = time() . '_' . $img_path->getClientOriginalName();
            // public/products フォルダに直接保存
            $img_path->move(public_path('products'), $filename);
            $img_pathPath = 'products/' . $filename;
            $img_pathPath = $product->img_path;
        }

        // データの更新
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'img_path' => $img_pathPath,
        ]);

        return redirect()->route('mypage')->with('success', '商品を更新しました！');
    }
}
