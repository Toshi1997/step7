<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product; //  追加

class SalesController extends Controller
{
    public function store(Request $request)
    {
        // バリデーション（product_id が必須で、productsテーブルに存在するIDであること）
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        //  商品情報を取得
        $product = Product::find($request->product_id);

        //  在庫が0以下なら購入できない
        if ($product->stock <= 0) {
            return response()->json([
                'message' => '在庫がありません。購入できません。'
            ], 400); // 400 Bad Request
        }

        //  在庫を1つ減らす
        $product->stock -= 1;
        $product->save();

        //  salesテーブルに購入記録を追加
        $sale = Sale::create([
            'product_id' => $product->id,
        ]);

        //  レスポンス返却
        return response()->json([
            'message' => '購入が完了しました。',
            'data' => $sale
        ]);
    }
}