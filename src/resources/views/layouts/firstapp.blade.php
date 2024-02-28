<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atte</title>
  <!-- CSSファイルの読み込み -->
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/firstcommon.css') }}">
  <!-- yieldディレクティブを使用して動的にCSSを読み込む -->
  @yield('css')
</head>

<body>
  <!-- ヘッダー -->
  <header class="header">
    <!-- ヘッダーの内部 -->
    <div class="header__inner">
      <!-- ヘッダーのユーティリティ領域 -->
      <div class="header-utilities">
        <!-- ヘッダーのロゴ -->
        <p>Atte</p>
      </div>
    </div>
  </header>

  <!-- メインコンテンツ -->
  <main>
    <!-- コンテンツを動的に挿入 -->
    @yield('content')
  </main>

  <!-- フッター -->
  <footer class="footer">
    <!-- フッターのテキスト -->
    <p>Atte, Inc.</p>
  </footer>

</body>

</html>