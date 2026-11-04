@extends('app')

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container item-list-container">
    <h2>商品一覧</h2>

    <!-- 検索フォームなどが必要な場合はここに配置 -->

    <table class="item-table">
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
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>
                        @if(!empty($item->image))
                            <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" class="item-thumbnail">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ number_format($item->price) }}</td>
                    <td>
                    <a href="{{ route('item.show', $item->id) }}" class="btn-detail">詳細</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection