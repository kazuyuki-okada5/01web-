<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance Management</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <!-- Bladeの@yieldディレクティブを使用して、ページ固有のCSSファイルを読み込み -->
  @yield('css')
</head>

<body>
  <!-- ヘッダー部分 -->
  <header class="header">
    <div class="header__inner">
      <div class="header-utilities">
        <!-- ロゴ -->
        <a class="header__logo" href="/">
          Attendance Management
        </a>
        <!-- ナビゲーションメニュー -->
        <nav>
          <ul class="header-nav">
            <!-- ユーザーがログインしている場合のみ表示 -->
            @if (Auth::check())
            <!-- マイページへのリンク -->
            <li class="header-nav__item">
              <a class="header-nav__link" href="/mypage">マイページ</a>
            </li>
            <!-- ログアウトボタン -->
            <li class="header-nav__item">
              <form class="form" action="/logout" method="post">
                @csrf
                <button class="header-nav__button">ログアウト</button>
              </form>
            </li>
            @endif
          </ul>
        </nav>
      </div>
    </div>
  </header>

  <!-- メインコンテンツ -->
  <main>
    <!-- 各ページごとのコンテンツ -->
    @yield('content')
  </main>
</body>

</html>
