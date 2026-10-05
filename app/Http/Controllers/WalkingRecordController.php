<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WalkingRecord; // ← モデルを読み込む！

class WalkingRecordController extends Controller
{
    public function index()
    {
    return view('index');
    }
    /**
     * 散歩記録の一覧表示 兼 検索処理
     */
   public function list(Request $request)
{
    $query = WalkingRecord::query();

    // 1. 年月の指定があれば絞り込み
    if ($request->filled('year_month')) {
        $query->where('walking_date', 'like', $request->year_month . '%');
    }

    if ($request->filled('search_date')) {
        $query->where('walking_date', $request->search_date);
    }

    // 2. 朝/夕の指定があれば絞り込み
    if ($request->filled('time_zone')) {
        $query->where('time_zone', $request->time_zone);
    }

    // 3. 散歩時間の指定があれば絞り込み
    if ($request->filled('minutes')) {
        $query->where('minutes', $request->minutes);
    }

    // 4. 備考欄の文字が含まれているか（部分一致検索）
    if ($request->filled('keyword')) {
        $query->where('memo', 'like', '%' . $request->keyword . '%');
    }

    // 日付が新しい順、かつ夕→朝に並び替えて取得
    $records = $query->orderBy('walking_date', 'desc')
                     ->orderBy('id', 'desc')
                     ->paginate(15)
                     ->withQueryString();

    // 登録されている年月を取得
    $yearMonths = WalkingRecord::selectRaw(
        "DATE_FORMAT(walking_date, '%Y-%m') as ym"
    )
    ->groupByRaw(
        "DATE_FORMAT(walking_date, '%Y-%m')"
    )
    ->orderByRaw(
        "DATE_FORMAT(walking_date, '%Y-%m') DESC"
    )
    ->pluck('ym');

    // Viewを表示
    return view('list', compact('records', 'yearMonths'));
}

    /**
     * 散歩記録の保存
     */
    public function store(Request $request)
    {
        
        // ① 送られてきたデータのバリデーション（入力チェック）
        $validated = $request->validate([
            'walking_date' => 'required|date',
            'time_zone'    => 'required|in:morning,evening',
            'minutes'      => 'required|integer|min:1',
            'memo' => 'nullable|string|max:50',
        ]);

        // ② データベースに保存
        WalkingRecord::create($validated);

        // ③ 保存後は元のページ（一覧）へ戻る＋ フラッシュメッセージ
        return redirect()->route('walking_records.index')->with('success', '入力が完了しました！');
    }

    /**
     * 散歩記録の削除
     */
    public function destroy($id)
    {
        // IDに該当するデータを取得（見つからなければ404）
        $item = WalkingRecord::findOrFail($id);
        
        // データを削除
        $item->delete();

        // 一覧画面に戻ってメッセージを表示
        return redirect()->route('walking_records.list')->with('success', '削除しました！');
    }

    public function edit($id)
{
    // 編集画面を表示する処理（例）
    $walkingRecord = WalkingRecord::findOrFail($id);
    return view('edit', compact('walkingRecord'));
}

/**
     * 散歩記録の更新処理
     */
    public function update(Request $request, $id)
    {
        // ① 送られてきたデータのバリデーション（入力チェック）
        $validated = $request->validate([
            'walking_date' => 'required|date',
            'time_zone'    => 'required|in:morning,evening',
            'minutes'      => 'required|integer|min:1',
            'memo'         => 'nullable|string|max:50',
        ]);

        // ② 該当するデータをデータベースから探す（見つからなければ404）
        $walkingRecord = WalkingRecord::findOrFail($id);

        // ③ データを新しい内容で上書き保存
        $walkingRecord->update($validated);

        // ④ 更新が終わったら一覧画面（または元のページ）にリダイレクト！
        return redirect()->route('walking_records.list');
    }
}