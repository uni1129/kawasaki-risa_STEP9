<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ログイン画面表示
    public function showLoginForm()
    {
        return view('login');
    }

    // ログイン処理
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // セッション認証を試みる
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ログイン成功時はホーム画面などにリダイレクト
            return redirect()->intended('/home');
        }

        // 失敗時はエラーメッセージと共にログイン画面に戻る
        return back()->withErrors([
            'email' => 'ログイン情報が正しくありません。',
        ])->onlyInput('email');
    }

    // 会員登録画面表示
    public function showRegisterForm()
    {
        return view('register');
    }

    // 会員登録処理
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_kanji' => 'required|string|max:255',
            'name_kana' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'name_kanji' => $request->name_kanji,
            'name_kana' => $request->name_kana,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('login');
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // API用ログイン処理を追加
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'ログインに失敗しました'], 401); //[cite: 5]
        }

        $user = Auth::user();

        // アクセストークンを発行
        $token = $user->createToken('auth_token')->plainTextToken; //[cite: 5]

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]); //[cite: 5]
    }
}
