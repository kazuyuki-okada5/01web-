@extends('layouts.secondapp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendees.css') }}">
@endsection

@section('content')
<div class="attendees__content">
    <table class="attendees_table">
        <tr class="item_tr">
            <th class="item_th">名前</th>
            <th class="item_th">勤務開始</th>
            <th class="item_th">勤務終了</th>
            <th class="item_th">休憩時間</th>
            <th class="item_th">勤務時間</th>
        </tr>
        @foreach ($lists as $item)
        <tr class="info_tr">
            <td class="info_td">{{ $item->name }}</td>
            <td class="info_td">{{ $item->start_time }}</td>
            <td class="info_td">{{ $item->end_time }}</td>
            <td class="info_td">{{ $item->break_hours }}</td>
            <td class="info_td">{{ $item->total_hours }}</td>
        </tr>
        @endforeach
    </table>

    {{ $lists->links() }} <!-- これがページネーションを表示する部分 -->
</div>
@endsection