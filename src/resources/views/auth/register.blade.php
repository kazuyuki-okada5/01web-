@extends('layouts.firstapp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__content">
    <!-- 会員登録フォームの見出し -->
    <div class="register-form__heading">
        <h2>会員登録</h2>
    </div>

    <!-- 会員登録フォーム -->
    <form class="form" action="/register" method="post">
        @csrf
        <!-- 名前入力欄 -->
        <div class="form__group">
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="名前" />
                </div>
                <!-- バリデーションエラーメッセージ -->
                <div class="form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <!-- メールアドレス入力欄 -->
        <div class="form__group">
            <div class="form__group-content">
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
        <!-- パスワード入力欄 -->
        <div class="form__group">
            <div class="form__group-content">
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
        <!-- パスワード確認入力欄 -->
        <div class="form__group">
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="password" name="password_confirmation" placeholder="確認用パスワード" />
                </div>
            </div>
        </div>
        <!-- 会員登録ボタン -->
        <div class="form__group">
            <div class="form__button">
                <button class="form__button-submit" type="submit">会員登録</button>
            </div>
        </div>
    </form>

    <!-- ログインへのリンク -->
    <div class="form__group-title">
        <span class="form__label--item">アカウントをお持ちの方はこちらから</span>
    </div>
    <div class="login__link">
        <a class="login__button-submit" href="/login">ログイン</a>
    </div>
</div>
@endsection
