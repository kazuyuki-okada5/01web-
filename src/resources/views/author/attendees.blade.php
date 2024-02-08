@extends('layouts.secondapp')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendees.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@endsection

@section('content')
<<div class="date-navigation">
    <a href="{{ route('attendees.move.date', ['direction' => 'prev', 'currentDate' => $currentDate]) }}">前日</a>
<span>{{ $currentDate }}</span>
<a href="{{ route('attendees.move.date', ['direction' => 'next', 'currentDate' => $currentDate]) }}">翌日</a>
</div>

    <div class="attendees__content">
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
                        <td class="info_td">{{ $book->break_hours_formatted }}</td>
                        <td class="info_td">{{ $book->total_hours_formatted }}</td>
                    </tr>
            @endforeach
            @else
@endif
        </table>
        @if ($books)
    <!-- $books 変数が null でない場合にのみ実行 -->
    <div class="attendees__content">
        <!-- データの表示や処理 -->
        {{ $books->withQueryString()->links() }}
    </div>
@else
        <p>表示すべきデータがありません。</p>
@endif
</div>
@endsection