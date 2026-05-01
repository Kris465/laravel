<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-Content-Security-Policy" content="default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data:;">
    <title>@yield('title', 'Helamin')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>

    {{-- Глобальная навигация --}}
    <nav class="main-nav">
        <div class="container main-nav__inner">
            <button class="main-nav__burger" id="burgerBtn" aria-label="Открыть меню" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>

            <ul class="main-nav__list" id="mainNav">
                <li><a href="{{ url('/') }}" class="main-nav__link @if(request()->is('/')) main-nav__link--active @endif">ГЛАВНАЯ</a></li>
                <li><a href="{{ url('/o-produkte') }}" class="main-nav__link @if(request()->is('o-produkte*')) main-nav__link--active @endif">О ПРОДУКТЕ</a></li>
                <li><a href="{{ url('/oblast-primeneniya') }}" class="main-nav__link @if(request()->is('oblast-primeneniya*')) main-nav__link--active @endif">ОБЛАСТИ ПРИМЕНЕНИЯ</a></li>
                <li><a href="{{ url('/otrasli-promyshlennosti') }}" class="main-nav__link @if(request()->is('otrasli-promyshlennosti*')) main-nav__link--active @endif">ОТРАСЛИ ПРОМЫШЛЕННОСТИ</a></li>
                <li><a href="{{ url('/news') }}" class="main-nav__link @if(request()->is('news*')) main-nav__link--active @endif">НОВОСТИ</a></li>
                <li><a href="{{ url('/biblioteka') }}" class="main-nav__link @if(request()->is('biblioteka*')) main-nav__link--active @endif">БИБЛИОТЕКА</a></li>
                <li><a href="{{ url('/referentsii') }}" class="main-nav__link @if(request()->is('referentsii*')) main-nav__link--active @endif">РЕФЕРЕНЦИИ</a></li>
                <li><a href="{{ url('/contacts') }}" class="main-nav__link @if(request()->is('contacts')) main-nav__link--active @endif">КОНТАКТЫ</a></li>
            </ul>
        </div>
    </nav>

    <main class="main">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container footer__inner">
            <div class="footer__brand">
                <span class="logo-main">HELAMIN</span>
                <p class="footer__tagline">Средства для водоподготовки и&nbsp;защиты от&nbsp;коррозии</p>
            </div>
            <div class="footer__contacts">
                <p><strong>Телефон:</strong> <a href="tel:+74957953605">+7 (495) 795-36-05</a></p>
                <p><strong>Email:</strong> <a href="mailto:info@helamin.ru">info@helamin.ru</a></p>
            </div>
            <div class="footer__info">
                <p>Helamin 1998&ndash;{{ date('Y') }}. Использование материалов сайта</p>
                <p>допускается только с&nbsp;разрешения правообладателя.</p>
                <p>Гиперссылка на&nbsp;источник обязательна.</p>
            </div>
            <div class="footer__copy">
                &copy; {{ date('Y') }} Helamin. Все права защищены.
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
