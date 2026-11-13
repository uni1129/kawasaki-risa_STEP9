@extends('app')

@section('content')
<div class="account-edit-container">
    <h2 class="account-edit-title">アカウント情報編集</h2>

    <form method="POST" action="{{ route('account.update') }}">
        @csrf
        @method('PUT')

        <!-- ユーザ名 -->
        <div class="account-form-group">
            <label class="account-form-label">ユーザ名</label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="account-form-input">
        </div>

        <!-- Eメール -->
        <div class="account-form-group">
            <label class="account-form-label">Eメール</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="account-form-input">
        </div>

        <!-- 名前 -->
        <div class="account-form-group">
            <label class="account-form-label">名前</label>
            <input type="text" name="kanji" value="{{ old('name_kanji', $user->name_kanji) }}" class="account-form-input">
        </div>

        <!-- カナ -->
        <div class="account-form-group">
            <label class="account-form-label">カナ</label>
            <input type="text" name="kana" value="{{ old('name_kana', $user->name_kana) }}" class="account-form-input">
        </div>

        <div class="account-button-group">
            <a href="{{ route('mypage') }}" class="account-btn-back">戻る</a>
            <button type="submit" class="account-btn-update">更新</button>
        </div>
    </form>
</div>
@endsection