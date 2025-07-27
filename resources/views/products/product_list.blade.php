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