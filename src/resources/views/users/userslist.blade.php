@extends('layouts.secondapp')

@section('css')
    <!-- CSSファイルの読み込み -->
    <link rel="stylesheet" href="{{ asset('css/userslist.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@endsection

@section('content')
<body>
    <div class="stamp__content">
        <!-- ユーザー名の表示 -->
        <div class="stamp__name">
            <!-- ログイン中のユーザー名を表示 -->
            @if(auth()->check())
                <p>{{ auth()->user()->name }} さんの勤務履歴</p>
            @endif
        </div>
        <br>

        <!-- 検索フォーム -->
        <!-- ユーザーの勤務履歴を検索するためのフォーム -->
        <form action="{{ route('users.index') }}" method="GET">
            <input type="text" name="keyword" placeholder="勤務確認したい名前を入力">
            <button type="submit">検索</button>
        </form>

        <!-- メッセージ領域 -->
        <!-- ユーザーに対するメッセージを表示する領域 -->
        <div id="message"></div>

        <!-- ユーザーの勤務履歴テーブル -->
        <div class="users list_content">
            <!-- 勤務履歴を表示するテーブル -->
            <table class="users list_table">
                <tr class="item_tr">
                    <!-- テーブルのヘッダー -->
                    <th class="item_th">勤務日</th>
                    <th class="item_th">勤務開始</th>
                    <th class="item_th">勤務終了</th>
                    <th class="item_th">休憩時間</th>
                    <th class="item_th">勤務時間</th>
                </tr>
                @if (!empty($books))
                    <!-- 勤務履歴がある場合 -->
                    @foreach ($books as $book)
                        <tr class="info_tr">
                            <!-- 勤務日 -->
                            <td class="info_td">{{ $book->login_date }}</td>
                            <!-- 勤務開始時間 -->
                            <td class="info_td">{{ \Carbon\Carbon::parse($book->start_time)->format('H:i:s') }}</td>
                            <!-- 勤務終了時間 -->
                            <td class="info_td">{{ $book->end_time }}</td>
                            <!-- 休憩時間 -->
                            <td class="info_td">
                                @php
                                    // 休憩時間を取得し、秒からh:m:s形式に変換する
                                    $totalSeconds = $book->totalBreakSeconds->total_break_seconds;
                                    $hours = floor($totalSeconds / 3600);
                                    $minutes = floor(($totalSeconds % 3600) / 60);
                                    $seconds = $totalSeconds % 60;
                                    $formattedTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                                @endphp
                                {{ $formattedTime }}
                            </td>
                            <!-- 勤務時間 -->
                            <td class="info_td">
                                @php
                                    // 勤務時間を計算し、休憩時間を差し引いてh:m:s形式に変換する
                                    $startTime = \Carbon\Carbon::parse($book->start_time);
                                    $endTime = \Carbon\Carbon::parse($book->end_time);
                                    $breakTimeSeconds = $book->totalBreakSeconds->total_break_seconds ?? 0;
                                    
                                    $workDuration = $endTime->diffInSeconds($startTime);
                                    $workDuration -= $breakTimeSeconds;
                                    
                                    $hours = floor($workDuration / 3600);
                                    $minutes = floor(($workDuration % 3600) / 60);
                                    $seconds = $workDuration % 60;
                                    $formattedWorkTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                                @endphp
                                {{ $formattedWorkTime }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <!-- 勤務履歴がない場合のメッセージ -->
                    <tr>
                        <td colspan="5">勤務履歴がありません。</td>
                    </tr>
                @endif
            </table>

            <!-- ページネーションリンク -->
            <!-- ページネーションリンクを表示 -->
            {{ $books->withQueryString()->links() }}
        </div>
    </div>
</body>
@endsection
