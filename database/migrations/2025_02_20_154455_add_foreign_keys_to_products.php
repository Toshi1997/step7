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
        Schema::table('products', function (Blueprint $table) {
            // company_id に外部キーを設定
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade'); // 企業が削除されたら、その企業の商品のデータも削除
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // 外部キーを削除（ロールバック用）
            $table->dropForeign(['company_id']);
        });
    }
};
