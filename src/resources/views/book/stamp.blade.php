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
            <!-- 勤務開始フォーム -->
            <form method="post" action="{{ route('log-activity', ['action' => 'startWork']) }}">
                @csrf
                <button type="submit" {{ $startButtonDisabled ? 'disabled' : '' }} class="{{ $startButtonDisabled ? 'disabled-button' : '' }}">勤務開始</button>
            </form>

            <!-- 勤務終了フォーム -->
            <form method="post" action="{{ route('log-activity', ['action' => 'endWork']) }}">
                @csrf
                <button type="submit" {{ $endButtonDisabled ? 'disabled' : '' }} class="{{ $endButtonDisabled ? 'disabled-button' : '' }}">勤務終了</button>
            </form>
        </div>

        <!-- 休憩開始フォーム -->
        <div class="button-container">
            <form method="post" action="{{ route('log-activity', ['action' => 'startBreak']) }}">
                @csrf
                <button type="submit" {{ $breakStartButtonDisabled ? 'disabled' : '' }} class="{{ $breakStartButtonDisabled ? 'disabled-button' : '' }}">休憩開始</button>
            </form>

            <!-- 休憩終了フォーム -->
            <form method="post" action="{{ route('log-activity', ['action' => 'endBreak']) }}">
                @csrf
                <button type="submit" {{ $breakEndButtonDisabled ? 'disabled' : '' }} class="{{ $breakEndButtonDisabled ? 'disabled-button' : '' }}">休憩終了</button>
            </form>
        </div>
    </div>
</body>
@endsection