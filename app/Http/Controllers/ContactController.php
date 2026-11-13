<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; 
use App\Mail\ContactShipped;

class ContactController extends Controller
{
    // お問い合わせ画面を表示する
    public function index()
    {
        return view('contact');
    }

    // お問い合わせを送信する処理（メール送信のみ）
    public function send(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'name'    => 'required|max:255',
            'email'   => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // 管理者宛てにメールを送信
        $adminEmail = 'risajm.0307@icloud.com';
        
        $contactData = [
            'sender_name'  => $validated['name'],
            'sender_email' => $validated['email'],
            'message'      => $validated['message'],
        ];

        Mail::to($adminEmail)->send(new ContactShipped($contactData));

        // 完了メッセージとともにリダイレクト
        return redirect()->route('home')->with('success', 'お問い合わせを送信しました！');
    }
}