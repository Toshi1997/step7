@extends('layouts.app')

@section('title', '商品編集')

@section('content')

<div class="container">
    <h1>商品編集</h1>

    <!-- ✅ フラッシュメッセージの表示 -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- ✅ エラーメッセージの表示 -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ✅ フォーム -->
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- 商品名 -->
        <div class="form-group">
            <label for="product_name">商品名</label>
            <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
        </div>

        <!-- 価格 -->
        <div class="form-group">
            <label for="price">価格</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
        </div>

        <!-- 在庫 -->
        <div class="form-group">
            <label for="stock">在庫</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
        </div>

        <!-- 企業選択 -->
        <div class="form-group">
            <label for="company_id">企業</label>
            <select name="company_id" class="form-control" required>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ $product->company_id == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- 商品説明 -->
        <div class="form-group">
            <label for="comment">説明</label>
            <textarea name="comment" class="form-control">{{ old('comment', $product->comment) }}</textarea>
        </div>

        <!-- 画像アップロード -->
        <div class="form-group">
            <label for="img_path">商品画像</label>
            <input type="file" name="img_path" class="form-control-file">
            @error('img_path')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            @if ($product->img_path)
                <img src="{{ asset($product->img_path) }}" width="100">
            @else
                画像なし
            @endif
        </div>

        <!-- 更新ボタン -->
        <button type="submit" class="btn btn-primary">更新</button>
    </form>

    <!-- 戻るボタン -->
    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">戻る</a>
</div>
@endsection