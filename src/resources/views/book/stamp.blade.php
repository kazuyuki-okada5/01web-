@extends('layouts.secondapp')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
@endsection

@section('content')
<body>
    <div class="stamp__content">
        @if (auth()->check())
            <p>{{ auth()->user()->name }} さんお疲れ様です！</p>
        @endif
        <br>
        <div id="message"></div>

         <div class="button-container">
    <!-- 既存の「勤務開始」と「勤務終了」のフォーム -->
    <form method="post" action="{{ route('log-activity', ['action' => 'startWork']) }}">
        @csrf
        <!-- 他のフォームフィールドなどがあればここに追加 -->
        <button type="submit">勤務開始</button>
    </form>

    <form method="post" action="{{ route('log-activity', ['action' => 'endWork']) }}">
        @csrf
        <button type="submit">勤務終了</button>
    </form>
</div>

<!-- 新しい「休憩開始」と「休憩終了」のフォーム -->
<div class="button-container">
    <form method="post" action="{{ route('log-activity', ['action' => 'startBreak']) }}">
        @csrf
        <button type="submit">休憩開始</button>
    </form>

    <form method="post" action="{{ route('log-activity', ['action' => 'endBreak']) }}">
        @csrf
        <button type="submit">休憩終了</button>
    </form>
</div>

        
    </div>
</body>
@endsection