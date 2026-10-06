<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>はっちゃんが歩いた時間</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-amber-50 min-h-screen">
    <!-- 外側を囲むフレックスコンテナ（縦並びにして中央揃え） -->
    <div class="min-h-screen flex flex-col items-center justify-center p-4">

        <!-- フラッシュメッセージ（メッセージがある時だけここに表示されるよ） -->
        @if (session('success'))
            <div class="mb-4 w-full max-w-lg bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-center shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- カード枠 -->
        <div class="bg-white rounded-xl border-2 border-amber-200 p-6 w-full max-w-lg shadow-sm">

            <!-- タイトル -->
            <h1 class="text-xl font-bold text-center text-amber-900 mb-6">
                はっちゃんが歩いた時間
            </h1>

            <!-- フォーム -->
            <form action="{{ route('walking_records.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- 入力項目エリア -->
                <div class="flex flex-col md:flex-row gap-6 items-start justify-center">

                    <!-- 日付 -->
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2 mb-1">
                            <label for="walking_date" class="text-gray-700 font-bold">日付</label>
                            <span class="bg-red-500 text-xs text-white font-bold px-2">必須</span>
                        </div>
                        <input type="date" name="walking_date" value="{{ old('walking_date') }}"
                            class="h-10 border-2 border-amber-300 rounded-lg px-3 text-center text-gray-700">
                        @error('walking_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 朝・夕の選択 -->
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2 mb-1">
                            <label for="time_zone" class="text-gray-700 font-bold">朝/夕</label>
                            <span class="bg-red-500 text-xs text-white font-bold px-2">必須</span>
                        </div>
                        <select name="time_zone"
                            class="border-2 h-10 border-amber-300 rounded-lg px-3 text-center text-gray-700">
                            <option value="">指定なし</option>
                            <option value="morning" {{ old('time_zone') === 'morning' ? 'selected' : '' }}>朝</option>
                            <option value="evening" {{ old('time_zone') === 'evening' ? 'selected' : '' }}>夕</option>
                        </select>
                        @error('time_zone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 分 -->
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2 mb-1">
                            <label for="minutes" class="text-gray-700 font-bold">時間</label>
                            <span class="bg-red-500 text-xs text-white font-bold px-2">必須</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <input type="number" name="minutes" value="{{ old('minutes', '22') }}" placeholder="22"
                                class="w-20 h-10 border-2 border-amber-300 rounded-lg px-3 text-center text-gray-700">
                            <span class="text-gray-700 font-bold">分</span>
                        </div>
                        @error('minutes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- メモ -->
                <div class="flex flex-col items-center">
                    <div class="w-full md:w-2/3 mb-1 text-left">
                        <label for="memo" class="text-gray-700 font-bold">メモ <span
                                class="text-gray-400 text-xs font-normal">（任意）</span></label>
                    </div>
                    <input type="text" name="memo" value="{{ old('memo') }}" placeholder="体調や気になること（50文字まで）"
                        maxlength="50" class="h-12 w-full md:w-2/3 border-2 border-amber-300 rounded-lg px-3 py-2 text-gray-700">
                </div>

                <!-- ボタン -->
                <div class="pt-4 flex justify-center items-center gap-4">
                    <!-- 送信ボタン -->
                    <button type="submit"
                        class="bg-amber-400 hover:bg-amber-500 text-white font-bold px-6 py-2 rounded-lg transition">
                        入力する
                    </button>

                    <!-- 一覧への移動リンク（ボタン風デザイン） -->
                    <a href="{{ route('walking_records.list') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-6 py-2 rounded-lg transition inline-block text-center">
                        一覧を見る
                    </a>
                </div>

            </form>

        </div>

    </div>
</body>

</html>