@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
    <div class="container">
        <!-- フラッシュメッセージを表示 -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1>商品一覧</h1>

        <!-- 検索・フィルター機能 -->
        <form action="{{ route('products.index') }}" method="GET" class="mb-3">
            <!-- 商品名検索 -->
            <div class="form-group">
                <input type="text" name="keyword" class="form-control" placeholder="商品名で検索" value="{{ request('keyword') }}">
            </div>
            
            <!-- メーカーセレクトボックス -->
            <div class="form-group">
                <select name="company_id" class="form-control">
                    <option value="">メーカーを選択</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">検索</button>
        </form>
        

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫</th>
                    <th>メーカー</th>
                    <th><a href="{{ route('products.create') }}" class="btn btn-warning">新規登録</a></th><!-- 新規登録ボタン -->
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                        @if ($product->img_path)
                            <img src="{{ asset($product->img_path) }}" width="100">
                        @else
                            画像なし
                        @endif
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ number_format($product->price) }} 円</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->company->company_name }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn btn-primary me-3">詳細</a>

                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">削除</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection