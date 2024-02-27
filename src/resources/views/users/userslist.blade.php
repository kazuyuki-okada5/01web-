@extends('layouts.secondapp')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/userslist.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@endsection

@section('content')
<body>
    <div class="stamp__content">
        <div class="stamp__name">
            @if(auth()->check())
                <p>{{ auth()->user()->name }} さんの勤務履歴</p>
            @endif
        </div>
        <br>
        <!-- 検索フォームを追加 -->
        <form action="{{ route('users.index') }}" method="GET">
            <input type="text" name="keyword" placeholder="勤務確認したい名前を入力">
            <button type="submit">検索</button>
        </form>


        <div id="message"></div>

        <div class="users list_content">
            <table class="users list_table">
                <tr class="item_tr">
                    <th class="item_th">勤務日</th>
                    <th class="item_th">勤務開始</th>
                    <th class="item_th">勤務終了</th>
                    <th class="item_th">休憩時間</th>
                    <th class="item_th">勤務時間</th>
                </tr>
                @if (!empty($books))
                    @foreach ($books as $book)
                        <tr class="info_tr">
                            <td class="info_td">{{ $book->login_date }}</td>
                            <td class="info_td">{{ \Carbon\Carbon::parse($book->start_time)->format('H:i:s') }}</td>
                            <td class="info_td">{{ $book->end_time }}</td>
                             <td class="info_td">
            @php
                // 秒数を時間に変換する
                $totalSeconds = $book->totalBreakSeconds->total_break_seconds;
                $hours = floor($totalSeconds / 3600);
                $minutes = floor(($totalSeconds % 3600) / 60);
                $seconds = $totalSeconds % 60;
                // 時間を "h:m:s" 形式にフォーマットする
                $formattedTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            @endphp
            {{ $formattedTime }}
        </td>
                            <td class="info_td">{{ $book->total_hours_formatted }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">勤務履歴がありません。</td>
                    </tr>
                @endif
            </table>
             <!-- ページネーションリンクを表示 -->
            {{ $books->withQueryString()->links() }}
        </div>
    </div>
</body>
@endsection