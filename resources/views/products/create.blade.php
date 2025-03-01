@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品登録</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="product_name" class="form-label">商品名</label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name') }}" required>
        </div>

        <div class="mb-3">
            <label for="company_id" class="form-label">企業</label>
            <select class="form-control" id="company_id" name="company_id" required>
                <option value="">選択してください</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">価格</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">在庫</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" required>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">説明</label>
            <textarea class="form-control" id="comment" name="comment">{{ old('comment') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="img_path" class="form-label">商品画像</label>
            <input type="file" class="form-control" id="img_path" name="img_path">
        </div>

        <button type="submit" class="btn btn-primary">登録</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection