<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
  // 商品一覧表示
  public function index()
  {
    $userId = Auth::id();

    $items = Item::where('user_id', '!=', $userId)
      ->orderBy('id', 'asc')
      ->get();

    return view('index', compact('items'));
  }

  // 商品新規登録画面を表示するメソッド
  public function create()
  {
    return view('item_register');
  }

  // 商品をデータベースに保存（新規登録の保存処理）
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'price' => 'required|integer|min:0',
      'description' => 'required|string',
      'stock' => 'required|integer',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $filename = time() . '_' . $image->getClientOriginalName();
      $image->move(public_path('items'), $filename);
      $imagePath = 'items/' . $filename;
    }

    Item::create([
      'user_id' => Auth::id(),
      'name' => $request->name,
      'price' => $request->price,
      'description' => $request->description,
      'stock' => $request->stock,
      'image' => $imagePath,
    ]);

    return redirect()->route('mypage')->with('success', '商品を出品しました！');
  }

  // 商品詳細表示
  public function show($id)
  {
    $item = Item::findOrFail($id);
    return view('exhibition_item_detail', compact('item'));
  }

  // 購入画面表示
  public function buy($id)
  {
    $item = Item::findOrFail($id);
    return view('buy', compact('item'));
  }


  public function purchase(Request $request, $id)
  {
    $item = Item::findOrFail($id);

    // 在庫数を超えていないかバリデーションする
    $request->validate([
      'quantity' => 'required|integer|min:1|max:' . $item->stock,
    ]);

    $quantity = $request->input('quantity', 1);

    // 注文履歴に保存
    Order::create([
      'user_id'  => Auth::id(),
      'item_id'  => $item->id,
      'quantity' => $quantity, 
      'price'  => $item->price,
    ]);

    // 在庫数を減らす（必要に応じて）
    $item->decrement('stock', $quantity);

    return redirect()->route('mypage')->with('success', '商品を購入しました！');
  }


  // 購入処理（購入完了）
  public function storeOrder(Request $request, $id)
  {
    $item = Item::findOrFail($id);

    Order::create([
      'user_id' => Auth::id(),
      'item_id' => $item->id,
      'price' => $item->price,
    ]);

    return redirect()->route('home')->with('success', '購入が完了しました！');
  }

  // 編集画面を表示
  public function edit($id)
  {
    $item = Item::findOrFail($id);

    if ($item->user_id !== Auth::id()) {
      return redirect()->route('mypage')->with('error', '権限がありません。');
    }

    return view('item_edit', compact('item'));
  }

  // 商品情報を更新
  public function update(Request $request, $id)
  {
    $item = Item::findOrFail($id);

    if ($item->user_id !== Auth::id()) {
      return redirect()->route('mypage')->with('error', '権限がありません。');
    }

    $request->validate([
      'name' => 'required|string|max:255',
      'price' => 'required|integer|min:0',
      'description' => 'required|string',
      'stock' => 'required|integer|min:0',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagePath = $item->image; // 画像を変更しない場合は元のパスを維持
    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $filename = time() . '_' . $image->getClientOriginalName();
      $image->move(public_path('items'), $filename);
      $imagePath = 'items/' . $filename;
    }

    $item->update([
      'name' => $request->name,
      'price' => $request->price,
      'description' => $request->description,
      'stock' => $request->stock,
      'image' => $imagePath,
    ]);

    return redirect()->route('mypage')->with('success', '商品を更新しました！');
  }

  // 商品を削除
  public function destroy($id)
  {
    $item = Item::findOrFail($id);

    if ($item->user_id !== Auth::id()) {
      return redirect()->route('mypage')->with('error', '権限がありません。');
    }

    $item->delete();

    return redirect()->route('mypage')->with('success', '商品を削除しました！');
  }
}
