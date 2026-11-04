@extends('app')

@section('content')
<div class="profile-edit-container">
    <h2>アカウント情報編集</h2>

    <!-- エラーメッセージ表示 -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 成功メッセージ表示 -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('account.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- ユーザ名 -->
        <div class="form-group">
            <label for="username">ユーザ名</label>
            <input type="text" name="username" id="username" value="{{ old('username', $user->username ?? '') }}" class="form-control" required>
        </div>

        <!-- Eメール -->
        <div class="form-group">
            <label for="email">Eメール</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="form-control" required>
        </div>

        <!-- 名前 -->
        <div class="form-group">
            <label for="name">名前</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" class="form-control" required>
        </div>

        <!-- カナ -->
        <div class="form-group">
            <label for="kana_name">カナ</label>
            <input type="text" name="kana_name" id="kana_name" value="{{ old('kana_name', $user->kana_name ?? '') }}" class="form-control" required>
        </div>

        <!-- ボタンエリア（戻る・更新） -->
        <div class="form-actions">
            <a href="{{ route('mypage') }}" class="btn-secondary">戻る</a>
            <button type="submit" class="btn-primary">更新</button>
        </div>
    </form>
</div>
@endsection