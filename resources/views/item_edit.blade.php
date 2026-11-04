@extends('app')

@section('content')
<div class="container">
  <div class="item-form-card">
    <h2>出品商品編集</h2>

    <form action="{{ route('item.update', $item->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
      @method('PUT')

      <!-- 商品名 -->
      <div class="form-group">
        <label for="name">商品名</label>
        <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}" class="form-control" required>
      </div>

      <!-- 価格 -->
      <div class="form-group">
        <label for="price">価格</label>
        <input type="number" id="price" name="price" value="{{ old('price', $item->price) }}" class="form-control" required min="0">
      </div>

      <!-- 商品説明 -->
      <div class="form-group">
        <label for="description">商品説明</label>
        <textarea id="description" name="description" class="form-control" rows="5" required>{{ old('description', $item->description) }}</textarea>
      </div>

      <!-- 在庫数 -->
      <div class="form-group">
        <label for="stock">在庫数</label>
        <input type="number" id="stock" name="stock" value="{{ old('stock', $item->stock ?? 0) }}" class="form-control" required min="0">
    </div>

      <!-- 商品画像 -->
      <div class="form-group">
        <label>商品画像</label>
        <div class="image-preview-area">
          @if($item->image)
          <img src="{{ asset('storage/' . $item->image) }}" alt="現在の画像>
          @endif
        </div>
        <input type="file" name="image" class="form-control-file">
      </div>

      <!-- ボタンエリア -->
      <div class="form-actions">
        <a href="{{ route('item.show', $item->id) }}" class="btn btn-secondary">戻る</a>
        <button type="submit" class="btn btn-primary">更新</button>
      </div>
    </form>
  </div>
</div>
@endsection