<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>はっちゃんが歩いた時間</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <h1 class="text-2xl font-bold mb-4 text-center text-gray-800">歩いた記録一覧</h1>
    <form action="{{ route('walking_records.list') }}" method="GET">

        <label>年月：</label>
        <select name="year_month">
            <option value="">指定なし</option>

        @foreach ($yearMonths as $yearMonth)
        <option value="{{ $yearMonth }}"
            {{ request('year_month') == $yearMonth ? 'selected' : '' }}>
            {{ \Carbon\Carbon::parse($yearMonth)->format('Y年n月') }}
        </option>
            @endforeach
        </select>

        <!-- 日付指定 -->
        <div class = "inline-block border-2 border-solid border-blue-400 rounded-lg p-2">
            <label>日付：</label>
            <input type="date" name="search_date" value="{{ request('search_date') }}" autocomplete="off">
        </div>

        <!-- 朝 / 夕 -->
        <label>時間帯：</label>
        <select name="time_zone">
            <option value="">指定なし</option>
            <option value="morning" {{ request('time_zone') == 'morning' ? 'selected' : '' }}>朝</option>
            <option value="evening" {{ request('time_zone') == 'evening' ? 'selected' : '' }}>夕</option>
        </select>

        <!-- 分数（20分など） -->
        <label>散歩時間（分）：</label>
        <input type="number" name="minutes" value="{{ request('minutes') }}" placeholder="例: 20">

        <!-- 備考欄キーワード（あいまい検索） -->
        <label>キーワード：</label>
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="例: 下痢、元気">

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            検索
        </button>
        <a href="{{ route('walking_records.list') }}" class="btn-clear inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded ml-2">
        クリア
        </a>
        <a href="{{ route('walking_records.index') }}" class="btn-clear inline-block bg-orange-500 hover:bg-orange-400 text-white font-bold py-2 px-4 rounded ml-2">
        入力画面に戻る
        </a>
    </form>

    {{-- セッションに 'success' というメッセージが入っていたら表示する --}}
@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif


    <!-- 検索フォームの後に追加 -->
    <div class="mt-8 space-y-2">
        @forelse ($records as $record)
            <div class="border-b pb-3 pt-2 flex items-center justify-between gap-4">
                <!-- 記録情報エリア -->
                <div class="flex flex-wrap items-center gap-4 text-gray-700">
                    <p><span class="text-xs text-gray-400 block">日付</span>{{ $record->walking_date }}</p>
                    <!-- DBにmorning/eveningで保存されているものをlist上で朝/夕に表示を切り替える -->
                    <p>
                        <span class="text-xs text-gray-400 block">時間帯</span>
                        {{ $record->time_zone === 'morning' ? '朝' : '夕' }}
                    </p>

                    <p><span class="text-xs text-gray-400 block">時間</span>{{ $record->minutes }}分</p>
                    <p><span class="text-xs text-gray-400 block">メモ</span>{{ $record->memo }}</p>
                </div>

                <!-- 操作ボタンエリア -->
                <div class="flex items-center gap-2 shrink-0">
                    <!-- 編集ボタン -->
                    <a href="{{ route('walking_records.edit', $record) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-3 py-1.5 rounded transition">
                        編集
                    </a>

                    <!-- 削除ボタン（フォームで送信） -->
                    <form action="{{ route('walking_records.destroy', $record) }}" method="POST"
                        onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-3 py-1.5 rounded transition">
                            削除
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 py-4">該当する散歩記録がありません。</p>
        @endforelse
    </div>
<!-- ページネーションのリンク（Tailwind用デザインを適用） -->
<div class="mt-4">
    {{ $records->appends(request()->query())->links('pagination::tailwind') }}
</div>
</body>
