@extends('app')

@section('content')
<div class="product-detail-container">
  <h1 class="product-detail-title">出品商品詳細</h1>

  <div class="product-detail-card">
    <!-- 商品名 -->
    <p class="product-detail-item"><strong>商品名：</strong> {{ $product->product_name }}</p>

    <!-- 説明 -->
    <p class="product-detail-item"><strong>説明：</strong> {{ $product->description }}</p>

    <!-- 画像 -->
    <div class="product-image-section">
      <p class="product-detail-label"><strong>画像：</strong></p>
      @if(!empty($product->img_path))
      <img src="{{ asset($product->img_path) }}" alt="{{ $product->product_name }}" class="product-detail-img">
      @else
      <p class="no-image-text">画像はありません</p>
      @endif
    </div>

    <!-- 金額 -->
    <p class="product-detail-item"><strong>金額：</strong> ¥{{ number_format($product->price) }}</p>

    <!-- ボタンエリア（編集・削除・戻る） -->
    <div class="product-actions">
      <a href="{{ route('mypage') }}" class="btn btn-secondary">戻る</a>

      <!-- 編集ボタン -->
      <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary">編集</a>

      <!-- 削除ボタン -->
      <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">削除する</button>
      </form>
    </div>
  </div>
</div>
@endsection