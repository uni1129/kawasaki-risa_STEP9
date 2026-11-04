@extends('app')

@section('content')
    <h2>商品一覧</h2>

    {{-- コントローラーからデータが渡されている場合の表示例 --}}
    @if(isset($items) && count($items) > 0)
        <ul>
            @foreach($items as $item)
                <li>{{ $item->name }}</li>
            @endforeach
        </ul>
    @else
        <p>データがありません。</p>
    @endif
@endsection