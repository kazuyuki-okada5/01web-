<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atte</title>
  <!-- CSSファイルの読み込み -->
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/secondcommon.css') }}">
  
  @yield('css')
</head>
<body>
  <!-- ヘッダー -->
  <header class="header">
    <div class="header__inner">
      <!-- ヘッダーの内部要素 -->
      <div class="header-utilities">
        <!-- Atteというテキストを表示 -->
        <p>Atte</p>
      </div>
      <!-- ログインしている場合のみ表示 -->
      @if (Auth::check())
      <div class="header-button">
        <!-- ボタン群 -->
        <div class="button-container">
          <!-- 各種ページへのリンク -->
          <a href="/" class="button">ホーム</a>
          <a href="/lists" class="button">日付一覧</a>
          <a href="/users_list" class="button">ユーザー一覧</a>
        </div>
        <!-- ログアウトのためのフォーム -->
        <form class="form" action="/logout" method="post">
          @csrf
          <button class="header-nav__button">ログアウト</button>
        </form>
      </div>
      @endif
    </div>
  </header>
  <!-- メインコンテンツ -->
  <main>
    <!-- 各ページごとのコンテンツを挿入 -->
    @yield('content')
  </main>
  <!-- フッター -->
  <footer>
    <!-- Atte, Inc. というテキストを表示 -->
    <p>Atte, Inc.</p>
  </footer>
</body>
</html>