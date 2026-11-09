<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cytech EC</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
  <header>
    <div class="header__title">Cytech EC</div>

    <nav class="header__nav">
      <a href="{{ route('home') }}" class="header__link">Home</a>
      <a href="{{ route('mypage') }}" class="header__link">マイページ</a>

      @auth
      <span class="header__user">ログインユーザー: {{ Auth::user()->name }}</span>

      <form action="{{ route('logout') }}" method="POST" class="header__logout-form">
        @csrf
        <button type="submit" class="btn btn-logout">ログアウト</button>
      </form>
      @endauth
    </nav>
  </header>

  <main class="main-content">
    @yield('content')
  </main>


  <footer class="footer">
    <div class="footer__contact">
      <a href="{{ route('contact.index') }}" class="btn btn-contact">お問い合わせ</a>
    </div>

    <div class="footer__nav">
      <a href="{{ route('home') }}" class="footer__link">Home</a>
      <a href="{{ route('mypage') }}" class="footer__link">マイページ</a>
    </div>

    <div class="footer__copyright">
      <p>© 2024 Company, Inc</p>
    </div>
  </footer>

  <script src="{{ asset('js/favorite.js') }}"></script>
</body>

</html>