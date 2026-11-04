@extends('app')

@section('content')
<div class="contact-container">
    
    <!-- タイトルと下線 -->
    <h2>お問い合わせフォーム</h2>

    <!-- エラーメッセージ表示 -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
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

    <form action="{{ route('contact.send') }}" method="POST">
        @csrf

        <!-- 名前 -->
        <div class="form-group">
            <label for="name">名前</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" class="form-control" required>
        </div>

        <!-- メールアドレス -->
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="form-control" required>
        </div>

        <!-- お問い合わせ内容 -->
        <div class="form-group">
            <label for="message">お問い合わせ内容</label>
            <textarea name="message" id="message" rows="6" class="form-control" required>{{ old('message') }}</textarea>
        </div>

        <!-- ボタンエリア（戻る・送信） -->
        <div class="form-actions">
            <a href="{{ route('mypage') }}" class="btn-secondary">戻る</a>
            <button type="submit" class="btn-primary">送信</button>
        </div>
    </form>
</div>
@endsection