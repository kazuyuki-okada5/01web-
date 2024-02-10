<!DOCTYPE html>
<html>
<head>
    <title>メール確認</title>
</head>
<body>
    <p>こんにちは、{{ $user->name ?? '' }}さん。</p>
    <p>以下のリンクをクリックして、メールアドレスを確認してください。</p>
    @if ($user)
        <a href="{{ url('email/verify/'.$user->id) }}">メールアドレスを確認する</a>
    @endif
</body>
</html>