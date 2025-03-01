<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    // 商品一覧を表示するメソッド
    public function index(Request $request)
    {
        // 企業一覧取得（セレクトボックス用）
        $companies = Company::all();

        // クエリビルダーで商品一覧を準備
        $query = Product::with('company');

        // 商品名の部分一致検索
        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
        }

        // 企業IDによるフィルター
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $products = $query->get();

        return view('products.index', compact('products', 'companies'));
    }


// ==============================================================

    // 新規登録画面の表示
    public function create()
    {
        $companies = Company::all(); // 企業リストを取得
        return view('products.create', ['companies' => $companies]);
    }


// ==============================================================

    // 商品登録処理
    public function store(ProductRequest $request)
    {
        $imagePath = null;
        if ($request->hasFile('img_path')) {
            // ディスク 'public' を指定し、"products" ディレクトリに保存
            $filePath = $request->file('img_path')->store('products', 'public');
            // DBには "storage/products/ファイル名" を保存
            $imagePath = 'storage/' . $filePath;
        }

        // 商品をデータベースに保存
        Product::create([
            'product_name' => $request->product_name,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'company_id'   => $request->company_id,
            'comment'      => $request->comment,
            'img_path'     => $imagePath, // "storage/products/ファイル名"
        ]);

        // 一覧ページへリダイレクト
        return redirect()->route('products.index')->with('success', '商品を登録しました！');
    }


// ==============================================================

    //商品を削除
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // 商品画像が存在する場合、ストレージから削除
        if ($product->img_path) {
            $storagePath = str_replace('storage/', '', $product->img_path); // 'images/ファイル名' に変換
            \Storage::disk('public')->delete($storagePath);
        }

        // 商品データを削除
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました！');
    }


// ==============================================================

    // 商品編集画面の表示
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all(); // 企業リストを取得

        return view('products.edit', compact('product', 'companies'));
    }

    // 商品情報の更新処理
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        // 画像のアップロード処理
        if ($request->hasFile('img_path')) {
            // ディスク名 'public' を指定して「products」ディレクトリに保存
            $filePath = $request->file('img_path')->store('products', 'public');
            // => 実際の保存先: storage\app\public\products\ファイル名
            // => $filePath = "products/ファイル名"
            $imagePath = 'storage/' . $filePath; // DBには "storage/products/ファイル名" を保存
            $product->img_path = $imagePath;
        }

        // 商品情報の更新
        $product->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'company_id' => $request->company_id,
            'comment' => $request->comment,
            'img_path' => $product->img_path, // `storage/products/ファイル名`
        ]);

        return redirect()->route('products.show', $product->id)->with('success', '商品情報を更新しました！');
    }

// ==============================================================

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

}
