@extends('layouts.secondapp')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendees.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@endsection

@section('content')
<div class="date-navigation">
    <!-- 日付ナビゲーション -->
    <div class="link-arrow-container">
        <a href="{{ route('attendees.move.date', ['direction' => 'prev', 'currentDate' => $currentDate]) }}" class="link-arrow">＜</a>
    </div>
    <span>{{ $currentDate }}</span>
    <div class="link-arrow-container">
        <a href="{{ route('attendees.move.date', ['direction' => 'next', 'currentDate' => $currentDate]) }}" class="link-arrow">＞</a>
    </div>
</div>

<div class="attendees__content">
    <div class="attendees__list">
        <table class="attendees_table">
            <tr class="item_tr">
                <th class="item_th">名前</th>
                <th class="item_th">勤務開始</th>
                <th class="item_th">勤務終了</th>
                <th class="item_th">休憩時間</th>
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
                        <td class="info_td">{{ $book->end_time }}</td>
                        <!-- 休憩時間 -->
                        <td class="info_td">
                            @php
                                // 休憩時間を秒から時間に変換してフォーマット
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
                                // 勤務時間を計算し、休憩時間を差し引いてフォーマット
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
                <!-- 表示すべきデータがない場合のメッセージ -->
                <tr>
                    <td colspan="5">表示すべきデータがありません。</td>
                </tr>
            @endif
        </table>
    </div>
</div>
@endsection