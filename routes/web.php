<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// ログイン・新規登録などの認証関連ルート
Auth::routes();

// ログイン後にアクセスするホーム画面
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ▼ ここから認証が必要なルートをまとめる
Route::group(['middleware' => ['auth']], function () {
    // 商品一覧ページ
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // 商品登録画面を表示
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

    // 商品登録処理
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // 削除リクエスト
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // 編集画面
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

    // 更新処理
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

    // 詳細画面（show）
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
});