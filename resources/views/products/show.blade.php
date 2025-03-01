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
    <h1>{{ $product->product_name }}</h1>
    <p><strong>価格:</strong> {{ number_format($product->price) }} 円</p>
    <p><strong>在庫:</strong> {{ $product->stock }}</p>
    <p><strong>企業:</strong> {{ $product->company->company_name }}</p>
    <p><strong>説明:</strong> {{ $product->comment }}</p>
    <div>
        @if ($product->img_path)
            <img src="{{ asset($product->img_path) }}" alt="{{ $product->product_name }}" width="300">
        @else
            <p>画像はありません</p>
        @endif
    </div>
    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">編集</a>
    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">戻る</a>
</div>
@endsection