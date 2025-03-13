@extends('layouts.app')

@section('title', '商品詳細')

@section('content')
<div class="container">
    <!-- フラッシュメッセージを表示 -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-borderless mt-4">
        <tr><th>ID</th><td>{{ $product->id }}</td></tr>
        <tr>
            <th class="align-top">商品画像</th>
            <td class="align-top">
                @if ($product->img_path)
                    <img src="{{ asset($product->img_path) }}" alt="{{ $product->product_name }}" width="300">
                @else
                    <p>画像はありません</p>
                @endif
            </td>
        </tr>
        <tr><th>商品名</th><td>{{ $product->product_name }}</td></tr>
        <tr><th>メーカー</th><td>{{ $product->company->company_name }}</td></tr>
        <tr><th>価格</th><td>{{ number_format($product->price) }} 円</td></tr>
        <tr><th>在庫</th><td>{{ $product->stock }}</td></tr>
        <tr><th>コメント</th><td>{{ $product->comment }}</td></tr>
    </table>
    
    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary mt-3">編集</a>
    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">戻る</a>
</div>
@endsection