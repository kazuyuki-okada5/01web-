@extends('layouts.firstapp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__content">
    <!-- ログインフォームの見出し -->
    <div class="login-form__heading">
        <h2>ログイン</h2>
    </div>

    <!-- ログインフォーム -->
    <form class="form" action="/login" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-content">
                <!-- メールアドレス入力欄 -->
                <div class="form__input--text">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス" />
                </div>
                <!-- バリデーションエラーメッセージ -->
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="form__group">
            <div class="form__group-content">
                <!-- パスワード入力欄 -->
                <div class="form__input--text">
                    <input type="password" name="password" placeholder="パスワード" />
                </div>
                <!-- バリデーションエラーメッセージ -->
                <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- ログインボタン -->
        <div class="form__button">
            <button class="form__button-submit" type="submit">ログイン</button>
        </div>
    </form>

    <!-- 会員登録へのリンク -->
    <div class="form__group-title">
        <span class="form__label--item">アカウントをお持ちでない方はこちらから</span>
    </div>
    <div class="register__link">
        <a class="register__button-submit" href="/register">会員登録</a>
    </div>
</div>
@endsection
