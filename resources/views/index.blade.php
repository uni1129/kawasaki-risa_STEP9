@extends('app')

@section('content')

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="container product-list-container">
    <h2>商品一覧</h2>

    <!-- 検索バー -->
    <form method="GET" action="{{ route('home') }}" class="search-form">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名を入力" class="search-input-text">
        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="最低価格" class="search-input-number">
        <span>〜</span>
        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="最高価格" class="search-input-number">
        <button type="submit" class="search-btn">検索</button>
    </form>

    <table class="product-table">
        <thead>
            <tr>
                <th>商品番号</th>
                <th>商品名</th>
                <th>商品説明</th>
                <th>画像</th>
                <th>料金(￥)</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->description }}</td>
                <td>
                    @if(!empty($product->img_path))
                    <!-- 先ほど確認した通り、public/products/ に保存されているためそのまま渡す -->
                    <img src="{{ asset($product->img_path) }}" alt="{{ $product->product_name }}" class="img">
                    @else
                    <span>画像なし</span>
                    @endif
                </td>
                <td>{{ number_format($product->price) }}</td>
                <td>
                    <a href="{{ route('product.exhibition', $product->id) }}" class="btn-detail">詳細</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection