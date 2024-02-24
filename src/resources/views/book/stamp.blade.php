@extends('layouts.secondapp')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
@endsection

@section('content')
    <div class="stamp__content">
        <!-- ログインしている場合に挨拶を表示 -->
        <div class="stamp-user">
            @if (auth()->check())
                <p>{{ auth()->user()->name }} さんお疲れ様です！</p>
            @endif
        </div>

        <br>
        <!-- メッセージを表示する領域 -->
        <div id="message"></div>

        <!-- ボタンコンテナ -->
        <div class="stamp-button-container">
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

        <!-- ボタンコンテナ -->
        <div class="stamp-button-container">
            <!-- 休憩開始フォーム -->
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
@endsection