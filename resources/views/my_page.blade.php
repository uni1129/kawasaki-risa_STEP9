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
        <p><strong>名前：</strong> {{ $user->real_name ?? $user->name }}</p>
        <p><strong>カナ：</strong> {{ $user->kana_name ?? '' }}</p>
      </div>
    </div>
  </div>

  <!-- 中部:出品商品エリア -->
  <div class="exhibition-section">
    <div class="section-header">
      <h3>&lt;出品商品&gt;</h3>
      <a href="{{ route('item.create') }}" class="btn-primary">新規登録</a>
    </div>

    <table class="item-table">
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
        @forelse($items as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->name }}</td>
          <td>{{ $item->description }}</td>
          <td>¥{{ number_format($item->price) }}</td>
          <td class="text-right">
            <a href="{{ route('exhibition.item.detail', $item->id) }}" class="btn-detail">詳細</a>
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

    <table class="item-table">
      <thead>
        <tr>
          <th>商品名</th>
          <th>商品説明</th>
          <th>料金(¥)</th>
          <th>個数</th>
        </tr>
      </thead>
      <tbody>
        @forelse($purchasedOrders ?? [] as $order)
        <tr>
          <td>{{ $order->item->name ?? '不明な商品' }}</td>
          <td>{{ $order->item->description ?? '' }}</td>
          <td>¥{{ number_format($order->item->price) }}</td>
          <td>{{ $order->quantity ?? 1 }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="empty-message">購入した商品はありません。</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>
@endsection