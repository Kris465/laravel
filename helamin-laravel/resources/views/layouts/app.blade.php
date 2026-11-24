<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Helamin')</title>
    {{-- Только SVG: favicon.ico в репозитории пустой (0 байт) и перебивал иконку.
         ?v= по mtime сбрасывает агрессивный кэш favicon в браузере. --}}
    <link rel="icon" href="{{ asset('favicon.svg') }}?v={{ filemtime(public_path('favicon.svg')) }}" type="image/svg+xml" sizes="any">
    <meta name="description" content="@yield('meta_description', 'HELAMIN — средства для водоподготовки и защиты от коррозии')">
    {{-- Версия по mtime: иначе браузер/прокси держит старый CSS по ETag после деплоя. --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}?v={{ filemtime(public_path('css/media.css')) }}">
    @stack('styles')
</head>
<body @class(['has-site-background' => filled($siteBackgroundUrl ?? null)]) @if(filled($siteBackgroundUrl ?? null)) style="--site-bg: url('{{ $siteBackgroundUrl }}');" @endif>

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
                <li><a href="{{ url('/news') }}" class="main-nav__link @if(request()->is('news*')) main-nav__link--active @endif">НОВОСТИ</a></li>
                <li><a href="{{ url('/biblioteka') }}" class="main-nav__link @if(request()->is('biblioteka*')) main-nav__link--active @endif">БИБЛИОТЕКА</a></li>
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
                <span class="logo-main logo-wordmark">HELAMIN</span>
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

    {{-- Просмотрщик PDF на весь экран. Лежит в layout, потому что превью теперь
         могут встречаться в тексте любой страницы. Скрыт до открытия, src
         подставляет public/js/app.js. --}}
    <div class="pdf-lightbox" id="pdfLightbox" hidden role="dialog" aria-modal="true" aria-label="Просмотр документа">
        <div class="pdf-lightbox__bar">
            <span class="pdf-lightbox__name" id="pdfLightboxName"></span>
            <span class="pdf-lightbox__actions">
                <a class="pdf-lightbox__download" id="pdfLightboxDownload" href="#" download>Скачать</a>
                <button type="button" class="pdf-lightbox__close" id="pdfLightboxClose" aria-label="Закрыть">&times;</button>
            </span>
        </div>
        <div class="pdf-lightbox__panel" id="pdfLightboxPanel">
            <iframe class="pdf-lightbox__frame" id="pdfLightboxFrame" title="Просмотр PDF"></iframe>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>
    @stack('scripts')
</body>
</html>
