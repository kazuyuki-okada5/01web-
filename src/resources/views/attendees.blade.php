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
                @foreach ($authors as $author)
                <tr class="info_tr">
                    <td class="info_td"></td>
                    <td class="info_td">{{$author->start_time}}</td>
                    <td class="info_td">{{$author->end_time}}</td>
                    <td class="info_td">{{$author->break_hours}}</td>
                    <td class="info_td">{{$author->total_hours}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>

@endsection