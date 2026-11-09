@extends('app')

@section('content')
    <h2>商品一覧</h2>

    {{-- コントローラーからデータが渡されている場合の表示例 --}}
    @if(isset($products) && count($products) > 0)
        <ul>
            @foreach($products as $product)
                <li>{{ $product->product_name }}</li>
            @endforeach
        </ul>
    @else
        <p>データがありません。</p>
    @endif
@endsection