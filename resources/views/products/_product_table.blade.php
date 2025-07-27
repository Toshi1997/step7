@foreach ($products as $product)
    <tr id="product-row-{{ $product->id }}">
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
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary me-3">詳細</a>
                <!--  削除ボタン -->
                <button class="btn btn-danger delete-btn me-3"
                        data-id="{{ $product->id }}"
                        data-url="{{ route('products.destroy', $product->id) }}">
                    削除
                </button>
                <!--  購入ボタン -->
                <button class="btn btn-success purchase-button"
                        data-product-id="{{ $product->id }}">
                    購入
                </button>
            </div>
        </td>
    </tr>
@endforeach