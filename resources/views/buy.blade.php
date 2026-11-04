@extends('app')

@section('content')
<div class="purchase-container">

  <!-- タイトル -->
  <h2>購入確認画面</h2>

  <!-- 商品情報セクション -->
  <div class="purchase-item-info">
    <h3 class="item-title">{{ $item->name }}</h3>
    <p class="item-price">金額：¥{{ number_format($item->price) }}</p>
  </div>

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

  <!-- 購入フォーム -->
  <form action="{{ route('item.purchase', $item->id) }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="quantity">数量</label>
      <!-- 在庫数を上限（max）に設定 -->
      <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ max(1, $item->stock ?? 1) }}" class="form-control" required>
    </div>

    <!-- ボタンエリア（戻る・購入する） -->
    <div class="form-actions">
      <a href="{{ route('item.show', $item->id) }}" class="btn-secondary">戻る</a>
      <button type="submit" class="btn-primary">購入する</button>
    </div>
  </form>
</div>
@endsection