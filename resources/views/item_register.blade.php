@extends('app')

@section('content')
<div class="container item-create-container">
    <h2>商品登録</h2>

    <!-- バリデーションエラー表示 -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
    @csrf


        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="price">価格</label>
            <input type="number" id="price" name="price" value="{{ old('price') }}" required>
        </div>

        <div class="form-group">
            <label for="description">商品説明</label>
            <textarea id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="stock">在庫数</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="image">商品画像</label>
            <input type="file" id="image" name="image">
        </div>

        <div class="form-actions">
            <a href="{{ route('home') }}" class="btn-secondary">戻る</a>
            <button type="submit" class="btn-primary">登録</button>
        </div>
    </form>
</div>
@endsection