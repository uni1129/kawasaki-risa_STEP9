<?php

namespace App\Http\Controllers;

use App\Models\TestUser; // 使用するモデルを呼び出す
use Illuminate\Http\Request;

class MypageController extends Controller
{
        // 画面の表示 ＋ DBデータの呼び出し

    public function index()
    {
        // Model データベース処理の呼び出し
        $user_data = TestUser::getUsers();

        //  画面データを渡して表示
        return view('mypage', compact('user_data'));
    }


      //フォーム送信データの受け取り ＋ 処理後のリダイレクト
      // フォーム送信データの取得・受け取り
    public function store(Request $request) 
    {
        $input_data = $request->all();

        return redirect()->route('mypage');
    }
}