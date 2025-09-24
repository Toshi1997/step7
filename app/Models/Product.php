<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'product_name', 'price', 'stock', 'comment', 'img_path'
    ];

    // 企業（Company）とのリレーション
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function processPurchase()
    {
        if ($this->stock <= 0) {
            throw new \Exception('在庫がありません。');
        }

        // 在庫を減らして保存
        $this->stock -= 1;
        $this->save();

        // 購入記録（Sale）を作成
        return $this->sales()->create([]);
    }

    // 売上（sales）とのリレーション
    public function sales()
    {
        return $this->hasMany(\App\Models\Sale::class);
    }
}