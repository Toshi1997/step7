<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'company_id' => 1, // 存在するcompany_idに変更すること！
                'product_name' => 'テスト商品A',
                'price' => 1000,
                'stock' => 10,
                'comment' => 'これはテスト商品Aの説明です。',
                'img_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'company_id' => 1,
                'product_name' => 'テスト商品B',
                'price' => 2000,
                'stock' => 5,
                'comment' => 'これはテスト商品Bの説明です。',
                'img_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
