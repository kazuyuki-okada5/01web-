@extends('layouts.secondapp')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendees.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@endsection

@section('content')
    <div class="date-navigation">
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
                    <td class="info_td">{{ $book->name }}</td>
                    <td class="info_td">{{ \Carbon\Carbon::parse($book->start_time)->format('H:i:s') }}</td>
                    <td class="info_td">{{ $book->end_time }}</td>
                    <td class="info_td">{{ $book->totalBreakSeconds->total_break_seconds }}</td> <!-- ここで休憩時間を表示 -->
                    <td class="info_td">{{ $book->total_hours_formatted }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5">表示すべきデータがありません。</td>
            </tr>
        @endif
    </table>
</div>
@endsection