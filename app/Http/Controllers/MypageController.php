<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Order; // ※購入履歴を管理するモデル

class MypageController extends Controller
{
    // マイページ表示（自分が出品した商品一覧・購入した商品一覧を取得）
    public function index() 
    {
        $user = Auth::user();

        // ログインユーザーが出品した商品（商品番号の昇順）
        $items = Item::where('user_id', $user->id)
            ->orderBy('id', 'asc')
            ->get();

        // 自分が購入した商品（購入日の昇順）
        $purchasedOrders = Order::where('user_id', $user->id)
            ->with('item')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('my_page', compact('user', 'items', 'purchasedOrders'));
    }

    // アカウント編集画面表示
    public function editAccount()
    {
        $user = Auth::user();
        return view('profile_edit', compact('user'));
    }

    // アカウント情報の更新処理
    public function updateAccount(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'name'     => 'required|string|max:255',
            'kana_name' => 'required|string|max:255', // ここが kana_name になっているか
        ]);

        $user = Auth::user();

        $user->update([
            'username'  => $request->username,
            'email'     => $request->email,
            'name'      => $request->name,
            'kana_name' => $request->kana_name, // ★ここも kana_name になっているか確認
        ]);

        return redirect()->route('mypage')->with('success', 'アカウント情報を更新しました！');
    }

    // 商品新規登録画面表示
    public function createItem()
    {
        return view('item_register');
    }

    // 出品商品詳細表示
    public function showItem($id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);
        return view('item_detail', compact('item'));
    }

    // 出品商品の削除
    public function destroy($id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);

        // 画像ファイルが保存されている場合はストレージから削除（任意）
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('mypage')->with('success', '商品を削除しました。');
    }

    // 出品商品編集画面表示
    public function editItem($id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);
        return view('item_edit', compact('item'));
    }


    // 出品商品の更新処理
    public function updateItem(Request $request, $id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);

        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 画像の差し替え処理
        $imagePath = $item->image;
        if ($request->hasFile('image')) {
            // 古い画像を削除する場合（必要に応じて）
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            $imagePath = $request->file('image')->store('items', 'public');
        }

        // データの更新
        $item->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('mypage')->with('success', '商品を更新しました！');
    }
}
