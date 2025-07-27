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

            <!-- 価格（下限〜上限） -->
            <div class="form-group d-flex mb-2">
                <input type="number" name="price_min" id="price_min" class="form-control me-2" placeholder="価格（下限）" value="{{ request('price_min') }}">
                <input type="number" name="price_max" id="price_max" class="form-control" placeholder="価格（上限）" value="{{ request('price_max') }}">
            </div>

            <!-- 在庫数（下限〜上限） -->
            <div class="form-group d-flex mb-3">
                <input type="number" name="stock_min" id="stock_min" class="form-control me-2" placeholder="在庫数（下限）" value="{{ request('stock_min') }}">
                <input type="number" name="stock_max" id="stock_max" class="form-control" placeholder="在庫数（上限）" value="{{ request('stock_max') }}">
            </div>
            
            <button type="submit" class="btn btn-primary">検索</button>
        </form>
        

        <table class="table">
        <thead>
            <tr>
                <th><a href="#" class="sortable" data-column="id">ID</a></th>
                <th>画像</th>
                <th><a href="#" class="sortable" data-column="product_name">商品名</a></th>
                <th><a href="#" class="sortable" data-column="price">価格</a></th>
                <th><a href="#" class="sortable" data-column="stock">在庫</a></th>
                <th><a href="#" class="sortable" data-column="company_id">メーカー</a></th>
                <th><a href="{{ route('products.create') }}" class="btn btn-warning">新規登録</a></th>
            </tr>
        </thead>
            <tbody id="product-table-body">
                @include('products._product_table')
            </tbody>
        </table>
    </div>

    <script>
        // Ajax通信の全てにCSRFトークンをセット（セキュリティのため）
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // 削除ボタンがクリックされたときの処理
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault(); // 通常のボタン動作を止める

            if (!confirm('本当に削除しますか？')) {
                return;
            }

            // ボタンにセットされた商品IDを取得
            const productId = $(this).data('id');

            //  修正後（data-url属性から取得）
            const url = $(this).data('url');

            // Ajaxで削除リクエストを送信
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function () {
                    // 成功したら、対象の商品行をHTMLから削除
                    $(`#product-row-${productId}`).remove();
                    alert('商品を削除しました！');
                },
                error: function () {
                    alert('削除に失敗しました');
                }
            });
        });


        $(function () {
            // 検索フォームの送信イベントをキャッチ
            $('#search-form').on('submit', function (e) {
                e.preventDefault(); // 通常のフォーム送信をキャンセル

                const formData = $(this).serialize();

                $.ajax({
                    url: '{{ route("products.index") }}',
                    type: 'GET',
                    data: formData,
                    dataType: 'html',
                    success: function (response) {
                        // 一時的にHTMLをdivでラップしてからtbodyだけ取り出す
                        const newBody = $('<div>').html(response).find('#product-table-body').html();
                        $('#product-table-body').html(newBody);
                    },
                    error: function () {
                        alert('検索に失敗しました。');
                    }
                });
            });
        });

        // JavaScriptでクリック時にソートしてAjax送信
        $(document).on('click', '.sortable', function () {
            const sortColumn = $(this).data('sort');
            const currentOrder = $(this).data('order');
            const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';

            $(this).data('order', newOrder); // 次回クリック用に切り替えておく

            const formData = $('#search-form').serializeArray(); // 検索フォームの内容取得
            formData.push({ name: 'sort_column', value: sortColumn });
            formData.push({ name: 'sort_order', value: newOrder });

            $.ajax({
                url: '{{ route("products.index") }}',
                type: 'GET',
                data: formData,
                dataType: 'html',
                success: function (response) {
                    const newBody = $('<div>').html(response).find('#product-table-body').html();
                    $('#product-table-body').html(newBody);
                },
                error: function () {
                    alert('ソートに失敗しました。');
                }
            });
        });

        // JavaScriptでクリックイベントを取得し、Ajaxで並び替えを実行
        let currentSortColumn = 'id';
        let currentSortOrder = 'asc';

        $(document).on('click', '.sortable', function (e) {
            e.preventDefault();

            const clickedColumn = $(this).data('column');

            // 同じ列をクリックしたら昇順⇔降順を切り替え、違う列なら昇順にリセット
            if (clickedColumn === currentSortColumn) {
                currentSortOrder = (currentSortOrder === 'asc') ? 'desc' : 'asc';
            } else {
                currentSortColumn = clickedColumn;
                currentSortOrder = 'asc';
            }

            // 現在の検索フォームの値を取得
            const keyword = $('#keyword').val();
            const companyId = $('#company_id').val();
            const priceMin = $('#price_min').val();
            const priceMax = $('#price_max').val();
            const stockMin = $('#stock_min').val();
            const stockMax = $('#stock_max').val();

            $.ajax({
                url: '{{ route("products.index") }}',
                type: 'GET',
                data: {
                    keyword: keyword,
                    company_id: companyId,
                    price_min: priceMin,
                    price_max: priceMax,
                    stock_min: stockMin,
                    stock_max: stockMax,
                    sort_by: currentSortColumn,
                    order: currentSortOrder
                },
                success: function (response) {
                    $('#product-table-body').html(response);
                },
                error: function () {
                    alert('ソートに失敗しました');
                }
            });
        });

        $(document).on('click', '.purchase-button', function () {
            const productId = $(this).data('product-id');

            $.ajax({
                url: 'http://127.0.0.1:8000/api/purchase',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ product_id: productId }),
                success: function(response) {
                    alert(response.message);

                    // 購入後に画面を自動更新
                    location.reload();
                },
                error: function(xhr) {
                    let msg = '購入に失敗しました。';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg += '\n' + xhr.responseJSON.message;
                    }
                    alert(msg);
                }
            });
        });
    </script>
@endsection