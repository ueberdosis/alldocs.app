<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
  @include('components.head.index')
</head>
<body>
  <div class="o-page" id="app">
    <header class="o-page__header">
      <a href="{{ url('/') }}">
        {{ config('app.name') }}
      </a>
    </header>

    <main class="o-page__content">
      @if (session()->has('message'))
        {{ session('message') }}
      @endif
      @yield('content')
    </main>

    <footer class="o-page__footer">
      @include('components.page-footer.index')
    </footer>
  </div>

  @include('components.footer.index')
</body>
</html>
