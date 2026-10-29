<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // マイページを表示するメソッド
    public function index()
    {
        // ビューファイル名が my_page.blade.php の場合
        return view('my_page');
    }

    // プロフィール編集画面を表示するメソッド
    public function edit()
    {
        // ビューファイル名が profile_edit.blade.php の場合
        return view('profile_edit');
    }

    // プロフィールを更新する処理のメソッド
    public function update(Request $request)
    {
        // 更新後にマイページへリダイレクト（移動）させる例
        return redirect()->route('mypage.index');
    }
}