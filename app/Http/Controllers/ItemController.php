<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    // 商品一覧
    public function index()
    {
        return view('index');
    }

    // 商品詳細
    public function show($id)
    {
        return view('item_detail');
    }

    // 購入画面
    public function buy($id)
    {
        return view('buy');
    }

    // 商品新規登録 (出品画面)
    public function create()
    {
        return view('item_register');
    }

    // 出品商品詳細
    public function showExhibition($id)
    {
        return view('exhibition_item_detail');
    }

    // 商品編集画面
    public function edit($id)
    {
        return view('item_edit');
    }
}