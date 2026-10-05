<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>はっちゃんが歩いた時間 - 編集</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-8">

    <h1 class="text-xl font-bold mb-4">歩行記録の編集</h1>

    <!-- データを更新するためのフォーム -->
    <form action="{{ route('walking_records.update', $walkingRecord->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- 編集（更新）のときのお約束 -->

        <!-- 日付 -->
        <div class="mb-4">
            <label for="walking_date" class="block">日付</label>
            <input type="date" name="walking_date" value="{{ old('walking_date', $walkingRecord->walking_date) }}"
                class="border p-1">
        </div>

        <div class="mb-4">
            <label for="time_zone" class="block">朝/夕</label>
            <select name="time_zone" class="border p-1">
                <!-- データベースの値（または直前に入力エラーになった値）がどっちだったか判定して、selectedをつけてあげる -->
                <option value="morning"
                    {{ old('time_zone', $walkingRecord->time_zone) === 'morning' ? 'selected' : '' }}>朝</option>
                <option value="evening"
                    {{ old('time_zone', $walkingRecord->time_zone) === 'evening' ? 'selected' : '' }}>夕</option>
            </select>
        </div>

        <!-- 時間（分） -->
        <div class="mb-4">
            <label for="minutes" class="block">時間（分）</label>
            <input type="number" name="minutes" value="{{ old('minutes', $walkingRecord->minutes) }}"
                class="border p-1">
        </div>

        <!-- メモ -->
        <div class="mb-4">
            <label for="memo" class="block">メモ</label>
            <input type="text" name="memo" placeholder="体調や気になること（50文字まで）" maxlength="50"
                value="{{ old('memo', $walkingRecord->memo) }}" class="border p-1">
        </div>

        <!-- 更新するボタン -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新する</button>
    </form>

    <!-- 戻るリンクたち -->
    <div class="mt-6 space-x-4">
        <!-- 一覧に戻る -->
        <a href="{{ route('walking_records.list') }}" class="text-blue-600 underline">
            一覧に戻る
        </a>
    </div>
    <div class="mt-6 space-x-4">
        <!-- 入力画面に戻る -->
        <a href="{{ route('walking_records.index') }}" class="text-blue-600 underline">
            入力画面に戻る
        </a>
    </div>

</body>

</html>
