<!-- resources/views/product_list.blade.php -->
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
        @forelse ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->description }}</td>
            <td>
                @if(!empty($product->img_path))
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
        @empty
        <tr>
            <td colspan="6">お探しの商品は見つかりませんでした。</td>
        </tr>
        @endforelse
    </tbody>
</table>