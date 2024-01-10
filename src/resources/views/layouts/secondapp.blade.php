<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atte</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/secondcommon.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
        <div class="header-utilities">
            <p>Atte</p>
        </div>
        <div class="header-button">
            <button class="button">ホーム</button>
            <button class="button">日付一覧</button>
            <button class="button">ログアウト</button>
        </div>
    </div>
  </header>

  <main>
    @yield('content')
  </main>
</body>
    <footer>
        <p>Atte, Inc.</p>
    </footer>

</html>