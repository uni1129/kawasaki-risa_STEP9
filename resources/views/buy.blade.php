@extends('app')

@section('content')
<div class="purchase-container">

  <h2>購入確認画面</h2>

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

  <!-- 購入フォームで全体を囲む -->
  <form id="purchase-form" data-product-id="{{ $product->id }}" data-mypage-url="{{ route('mypage') }}">
    @csrf

    <div class="purchase-product-info">
      <h4 class="product-title">商品名：{{ $product->product_name }}</h4>

      <!-- 商品説明 -->
      <div class="product-description-section">
        <p>商品説明：{{ $product->description ?? '商品説明はありません。' }}</p>
      </div>

      <!-- 画像 -->
      <div class="form-group" style="margin: 15px 0;">
        @if(!empty($product->img_path))
        <img src="{{ asset($product->img_path) }}" alt="{{ $product->product_name }}">
        @else
        <p>画像はありません</p>
        @endif
      </div>

      <!-- 購入個数 -->
      <div class="form-group" style="margin: 15px 0;">
        <label for="quantity">購入個数:</label>
        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width: 100px;">
      </div>

      <p class="product-price">金額：¥{{ number_format($product->price) }}</p>

      <!-- 在庫数 -->
      <div class="product-stock-section">
        <p>残り：{{ $product->stock ?? 0 }} </p>
      </div>

      <!-- 会社名 -->
      <div class="product-company-section">
        <p>会社：{{ $product->company_name ?? '' }}</p>
      </div>
    </div>

    <!-- ボタンエリア（戻る・購入する） -->
    <div class="form-actions" style="margin-top: 20px;">
      <a href="{{ route('product.show', $product->id) }}" class="btn-secondary">戻る</a>
      <button type="submit" class="btn-primary">購入する</button>
    </div>
  </form>
</div>

<!-- ★ 購入確認モーダル -->
<div id="purchase-modal" class="modal" style="display: none;">
  <div class="modal-content">
    <h2>購入の確認</h2>
    <p>この商品を本当に購入しますか？</p>
    <div class="modal-actions">
      <button type="button" id="modal-cancel" class="btn-secondary" style="background-color: #6c757d; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">キャンセル</button>
      <button type="button" id="modal-confirm" class="btn-primary" style="background-color: #4169e1; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">購入する</button>
    </div>
  </div>
</div>

<script src="{{ asset('js/purchase.js') }}"></script>
@endsection