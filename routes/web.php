<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalkingRecordController; // ← コントローラーを読み込む！

// トップページ（/）にアクセスがあったら、WalkingRecordControllerの index メソッドを呼び出す
Route::get('/', [WalkingRecordController::class, 'index'])->name('walking_records.index');

// 一覧ページ（list）
Route::get('/list', [WalkingRecordController::class, 'list'])->name('walking_records.list');

Route::post('/walking-records', [WalkingRecordController::class, 'store'])->name('walking_records.store');

// 編集画面を表示するルーティング（データIDを受け取る）
Route::get('/walking-records/{id}/edit', [WalkingRecordController::class, 'edit'])->name('walking_records.edit');

// 更新処理を実行するルーティング（POSTまたはPUT/PATCH）
Route::put('/walking-records/{id}', [WalkingRecordController::class, 'update'])->name('walking_records.update');

//削除
Route::delete('/walking-records/{id}', [WalkingRecordController::class, 'destroy'])->name('walking_records.destroy');