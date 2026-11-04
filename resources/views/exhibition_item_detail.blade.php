@extends('app')

@section('content')
<div class="container">
  <div class="item-detail-card">
    <h2>商品詳細</h2>

    <!-- 商品名 -->
    <div class="detail-group">
      <span class="detail-label">商品名：</span>
      <span class="detail-value">{{ $item->name }}</span>
    </div>

    <!-- 説明 -->
    <div class="detail-group">
      <span class="detail-label">説明：</span>
      <p class="detail-text">{{ $item->description }}</p>
    </div>

    <!-- 画像 -->
    <div class="detail-group">
      <span class="detail-label">画像：</span>
      <div class="detail-image-area" style="margin-top: 10px;">
        {{-- $item->image に値が入っているか確認 --}}
        @if(!empty($item->image))
        <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" style="max-width: 250px; height: auto; border-radius: 4px;">
        @else
        <p>画像はありません</p>
        @endif
      </div>
    </div>

    <!-- 金額 -->
    <div class="detail-group">
      <span class="detail-label">金額：</span>
      <span class="detail-price">¥{{ number_format($item->price) }}</span>
    </div>

    <!-- 会社名
    <div class="detail-group">
      <span class="detail-label">会社：</span>
      <span class="detail-value">{{ $item->user->name ?? 'TNG' }}</span>
    </div> -->

    <!-- お気に入りハートマーク（SVG版） -->
    <div class="detail-group" style="margin-top: 15px;">
      <div id="favorite-btn" class="favorite-icon-wrapper">
        <svg class="favorite-svg" viewBox="0 0 24 24" width="28" height="28">
          <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
        </svg>
      </div>
    </div>

    <!-- ボタンエリア -->
    <div class="form-actions">
      <a href="{{ route('home') }}" class="btn btn-secondary">戻る</a>
      <a href="{{ route('item.buy', $item->id) }}" class="btn btn-primary">カートに追加する</a>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/favorite.js') }}"></script>
@endsection