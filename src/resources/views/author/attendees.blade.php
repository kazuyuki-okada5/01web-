@extends('layouts.secondapp')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendees.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@endsection

@section('content')
<div class="date-navigation">
    <!-- 日付ナビゲーション -->
    <div class="link-arrow-container">
        <!-- 前の日付への移動リンク -->
        <a href="{{ route('attendees.move.date', ['direction' => 'prev', 'currentDate' => $currentDate]) }}" class="link-arrow">＜</a>
    </div>
    <span>{{ $currentDate }}</span>
    <div class="link-arrow-container">
        <!-- 次の日付への移動リンク -->
        <a href="{{ route('attendees.move.date', ['direction' => 'next', 'currentDate' => $currentDate]) }}" class="link-arrow">＞</a>
    </div>
</div>

<div class="attendees__content">
    <div class="attendees__list">
        <!-- 出席者リストのテーブル -->
        <table class="attendees_table">
            <tr class="item_tr">
                <!-- 列見出し: 名前 -->
                <th class="item_th">名前</th>
                <!-- 列見出し: 勤務開始 -->
                <th class="item_th">勤務開始</th>
                <!-- 列見出し: 勤務終了 -->
                <th class="item_th">勤務終了</th>
                <!-- 列見出し: 休憩時間 -->
                <th class="item_th">休憩時間</th>
                <!-- 列見出し: 勤務時間 -->
                <th class="item_th">勤務時間</th>
            </tr>
            @if (!empty($books))
    @foreach ($books as $book)
        <tr class="info_tr">
            <!-- 名前 -->
            <td class="info_td">{{ $book->name }}</td>
            <!-- 勤務開始時間 -->
            <td class="info_td">{{ \Carbon\Carbon::parse($book->start_time)->format('H:i:s') }}</td>
            <!-- 勤務終了時間 -->
            <td class="info_td">{{ \Carbon\Carbon::parse($book->end_time)->format('H:i:s') }}</td>
            <!-- 休憩時間 -->
            <td class="info_td">
                @php
                    // 休憩時間を秒から時間に変換してフォーマット
                    $total_break_seconds = $book->total_break_seconds ?? 0;
                    $breakHours = floor($total_break_seconds / 3600);
                    $breakMinutes = floor(($total_break_seconds % 3600) / 60);
                    $breakSeconds = $total_break_seconds % 60;
                    $formattedBreakTime = sprintf('%02d:%02d:%02d', $breakHours, $breakMinutes, $breakSeconds);
                @endphp
                {{ $formattedBreakTime }}
            </td>
            <!-- 勤務時間 -->
            <td class="info_td">
                @php
                    // 勤務時間を計算し、休憩時間を差し引いてフォーマット
                    $startTime = \Carbon\Carbon::parse($book->start_time);
                    $endTime = \Carbon\Carbon::parse($book->end_time);
                    
                    $workDurationSeconds = $endTime->diffInSeconds($startTime) - $total_break_seconds;
                    $workHours = floor($workDurationSeconds / 3600);
                    $workMinutes = floor(($workDurationSeconds % 3600) / 60);
                    $workSeconds = $workDurationSeconds % 60;
                    $formattedWorkTime = sprintf('%02d:%02d:%02d', $workHours, $workMinutes, $workSeconds);
                @endphp
                {{ $formattedWorkTime }}
            </td>
        </tr>
    @endforeach
@else
    <!-- データがない場合のメッセージ -->
    <tr>
        <td colspan="5">表示すべきデータがありません。</td>
    </tr>
@endif
        </table>
    </div>
    {{ $books->links() }}
</div>
@endsection