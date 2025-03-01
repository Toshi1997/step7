<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // 自動インクリメントのプライマリキー
            $table->unsignedBigInteger('company_id'); // 企業ID
            $table->string('product_name'); // 商品名
            $table->integer('price'); // 価格
            $table->integer('stock'); // 在庫数
            $table->text('comment')->nullable(); // 商品説明（任意）
            $table->string('img_path')->nullable(); // 画像パス（任意）
            $table->timestamps(); // created_at, updated_at 自動作成      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
