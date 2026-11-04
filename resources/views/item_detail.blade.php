@extends('app')

@section('content')
<div class="container item-create-container">
  <h2>出品商品詳細</h2>

  <div class="item-detail-content">

    <!-- 商品名 -->
    <div class="form-group">
      <label>商品名</label>
      <div class="item-detail-value">{{ $item->name }}</div>
    </div>

    <!-- 商品説明 -->
    <div class="form-group">
      <label>商品説明</label>
      <div class="item-detail-value description-text">{{ $item->description }}</div>
    </div>

    <!-- 商品画像 -->
    <div class="detail-group">
      <span class="detail-label">画像：</span>
      <div class="detail-image-area">
        @if(!empty($item->image))
          <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" class="item-detail-image">
        @else
          <p>画像はありません</p>
        @endif
      </div>
    </div>

    <!-- 価格 -->
    <div class="form-group">
      <label>価格</label>
      <div class="item-detail-value">¥{{ number_format($item->price) }}</div>
    </div>

    <!-- ボタンエリア -->
    <div class="form-actions item-detail-actions">

      <!-- 左側：戻るボタン -->
      <div class="action-left">
        <a href="{{ route('mypage') }}" class="btn btn-secondary">マイページに戻る</a>
      </div>

      <!-- 右側：編集するボタン と 削除するボタン -->
      <div class="action-right">
        <a href="{{ route('item.edit', $item->id) }}" class="btn btn-primary">編集する</a>

        <form action="{{ route('item.destroy', $item->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');" class="delete-form">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">削除する</button>
        </form>
      </div>

    </div>
  </div>
</div>
@endsection