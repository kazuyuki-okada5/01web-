@extends('layouts.secondapp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
@endsection

@section('content')
<body>
    <div class="stamp__content">
        <label for="nameInput">名前を入力してください:</label>
        <input type="text" id="nameInput">
        <br>
        <div id="message"></div>
        <script>
            // ページが読み込まれた直後に実行
            window.onload = function() {
                var nameInput = document.getElementById("nameInput");
                var messageDiv = document.getElementById("message");
                // 入力欄が変更されるたびに呼び出される関数
                    nameInput.addEventListener("input", function() {
                        var name = nameInput.value;
                        messageDiv.innerHTML = name + " さん、お疲れ様です！";
                     });
                };
        </script>
        <div>
            <button class="atte_button" id="startButton" onclick="startWork()">勤務開始</button>
            <button class="atte_button" id="endButton" onclick="endWork()">勤務終了</button>
        </div>
        <div>
            <button class="atte_button" id="breakStartButton" onclick="startBreak()">休憩開始</button>
            <button class="atte_button" id="breakEndButton" onclick="endBreak()">休憩終了</button>
        </div>
    </div>
</body>
@endsection