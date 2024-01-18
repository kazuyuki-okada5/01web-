@extends('layouts.secondapp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendees.css') }}">
@endsection

@section('content')
<body>
    <div class="attendees__content">
        <div>
            <table class="attendess_table">
                <tr class="item_tr">
                    <th class="item_th">名前</th>
                    <th class="item_th">勤務開始</th>
                    <th class="item_th">勤務終了</th>
                    <th class="item_th">休憩時間</th>
                    <th class="item_th">勤務時間</th>
                </tr>
                @foreach ($items as $item)
                <tr class="info_tr">
                    <td class="info_td"></td>
                    <td class="info_td">{{$item->start_time}}</td>
                    <td class="info_td">{{$item->end_time}}</td>
                    <td class="info_td">{{$item->break_hours}}</td>
                    <td class="info_td">{{$item->total_hours}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>
@endsection