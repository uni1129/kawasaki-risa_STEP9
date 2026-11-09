@extends('app')

@section('content')
<div class="container mypage-container">

  <h2>マイページ</h2>

  <!-- 上部:ユーザー情報エリア -->
  <div class="user-profile-section">
    <div class="user-profile-actions">
      <a href="{{ route('account.edit') }}" class="btn-primary">アカウント編集</a>
    </div>
    <div class="user-profile-info">
      <div>
        <p><strong>ユーザ名:</strong> {{ $user->name ?? $user->username ?? 'Cy' }}</p>
        <p><strong>Eメール:</strong> {{ $user->email }}</p>
      </div>
      <div>
        <p><strong>名前：</strong> {{ $user->name_kanji ?? $user->name }}</p>
        <p><strong>カナ：</strong> {{ $user->name_kana ?? '' }}</p>
      </div>
    </div>
  </div>

  <!-- 中部:出品商品エリア -->
  <div class="exhibition-section">
    <div class="section-header">
      <h3>&lt;出品商品&gt;</h3>
      <a href="{{ route('product.create') }}" class="btn-primary">新規登録</a>
    </div>

    <table class="product-table">
      <thead>
        <tr>
          <th>商品番号</th>
          <th>商品名</th>
          <th>商品説明</th>
          <th>料金(¥)</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td>{{ $product->product_name }}</td>
          <td>{{ $product->description }}</td>
          <td>¥{{ number_format($product->price) }}</td>
          <td class="text-right">
            <a href="{{ route('mypage.product.detail', $product->id) }}" class="btn-detail">詳細</a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="empty-message">出品している商品はありません。</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- 下部:購入した商品エリア -->
  <div class="purchased-section">
    <h3>&lt;購入した商品&gt;</h3>

    <table class="product-table">
      <thead>
        <tr>
          <th>商品名</th>
          <th>商品説明</th>
          <th>料金(¥)</th>
          <th>個数</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sales as $sale)
        <tr>
          <td>{{ $sale->product->product_name ?? '不明な商品' }}</td>
          <td>{{ $sale->product->description ?? '' }}</td>
          <td>¥{{ number_format($sale->product?->price ?? 0) }}</td>
          <td>{{ $sale->quantity }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="4">購入した商品はありません。</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>
@endsection