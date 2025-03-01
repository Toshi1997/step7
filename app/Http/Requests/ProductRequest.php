<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * ユーザーがこのリクエストを許可されているかどうかを判定
     */
    public function authorize()
    {
        return true; 
    }

    /**
     * バリデーションルールの設定
     */
    public function rules()
    {
        return [
            'product_name' => 'required|max:255',
            'company_id'   => 'required|exists:companies,id',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
            'comment'      => 'max:10000',
            'img_path'     => 'nullable|mimes:jpeg,png,jpg,gif|max:2048', // 画像ファイルのみ許可
        ];
    }

    /**
     * 項目名（エラーメッセージで使われる）
     */
    public function attributes()
    {
        return [
            'product_name' => '商品名',
            'company_id'   => '企業',
            'price'        => '価格',
            'stock'        => '在庫',
            'comment'      => 'コメント',
            'img_path'     => '商品画像',
        ];
    }

    /**
     * エラーメッセージの設定
     */
    public function messages()
    {
        return [
            'product_name.required' => ':attribute は必須項目です。',
            'product_name.max' => ':attribute は :max 文字以内で入力してください。',
            'company_id.required' => ':attribute を選択してください。',
            'company_id.exists' => '選択された :attribute は無効です。',
            'price.required' => ':attribute は必須項目です。',
            'price.integer' => ':attribute は整数で入力してください。',
            'price.min' => ':attribute は 0 以上である必要があります。',
            'stock.required' => ':attribute は必須項目です。',
            'stock.integer' => ':attribute は整数で入力してください。',
            'stock.min' => ':attribute は 0 以上である必要があります。',
            'comment.max' => ':attribute は :max 文字以内で入力してください。',
            'img_path.image' => ':attribute は画像ファイルを選択してください。',
            'img_path.mimes' => ':attribute は jpeg, png, jpg, gif のいずれかの形式でアップロードしてください。',
            'img_path.max' => ':attribute は 2MB 以下のファイルを選択してください。',
        ];
    }
}
