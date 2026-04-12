<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'HELAMIN')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=roboto:400,500,700&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', Arial, sans-serif; line-height: 1.6; color: #333; background: #f5f5f5; }
        a { text-decoration: none; color: #0066cc; }
        a:hover { text-decoration: underline; }
        
        /* Header */
        #header { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; padding: 20px 0; }
        .header-top { display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .logo-section { display: flex; align-items: center; gap: 20px; }
        .logo-section img { max-height: 60px; }
        .slogan { font-size: 18px; font-weight: 500; }
        .slogan2 { font-size: 14px; color: #a8d5ff; margin-top: 5px; }
        .contact-info { text-align: right; }
        .phone { font-size: 20px; font-weight: 700; margin-bottom: 5px; }
        .email { color: #a8d5ff; }
        
        /* Navigation */
        #main-nav { background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        #main-nav ul { list-style: none; display: flex; flex-wrap: wrap; max-width: 1200px; margin: 0 auto; }
        #main-nav > ul { padding: 0 20px; }
        #main-nav li { position: relative; }
        #main-nav > ul > li { border-right: 1px solid #eee; }
        #main-nav > ul > li:last-child { border-right: none; }
        #main-nav a { display: block; padding: 15px 20px; color: #333; font-weight: 500; transition: all 0.3s; }
        #main-nav a:hover { background: #1e3c72; color: white; text-decoration: none; }
        
        /* Dropdown */
        #main-nav ul ul { display: none; position: absolute; top: 100%; left: 0; background: white; min-width: 250px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); z-index: 1000; }
        #main-nav li:hover > ul { display: block; }
        #main-nav ul ul li { border-bottom: 1px solid #eee; }
        #main-nav ul ul a { padding: 12px 20px; font-size: 14px; }
        #main-nav ul ul a:hover { background: #f5f5f5; }
        
        /* Main content */
        #main-content { max-width: 1200px; margin: 0 auto; padding: 40px 20px; background: white; min-height: 60vh; }
        #main-content h1 { color: #1e3c72; margin-bottom: 25px; font-size: 32px; }
        #main-content h2 { color: #2a5298; margin: 25px 0 15px; font-size: 24px; }
        #main-content h3 { color: #333; margin: 20px 0 10px; font-size: 18px; }
        #main-content p { margin-bottom: 15px; }
        #main-content ul { margin-left: 25px; margin-bottom: 20px; }
        #main-content li { margin-bottom: 8px; }
        
        /* Footer */
        #footer { background: #1e3c72; color: white; padding: 30px 0; margin-top: 40px; }
        #footer .footer-content { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; }
        #footer h4 { margin-bottom: 15px; color: #a8d5ff; }
        #footer p { margin-bottom: 10px; }
        #footer a { color: #a8d5ff; }
        #footer-bottom { text-align: center; padding-top: 20px; margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); max-width: 1200px; margin: 20px auto 0; }
        
        /* Container */
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
    </style>
    
    @stack('styles')
</head>
<body>
    <div id="page-wrapper">
        <!-- Header -->
        <header id="header">
            <div class="header-top">
                <div class="logo-section">
                    <div>
                        <div class="slogan">HELAMIN®</div>
                        <div class="slogan2">Без гидразина<br>Без фосфатов</div>
                    </div>
                </div>
                <div class="contact-info">
                    <div class="phone">+7 (495) 795-36-05</div>
                    <div class="email">info@helamin.ru</div>
                </div>
            </div>
        </header>
        
        <!-- Navigation -->
        <nav id="main-nav">
            <ul>
                <li><a href="/">Главная</a></li>
                <li>
                    <a href="/o-produkte">О продукте</a>
                    <ul>
                        <li><a href="/o-produkte#opisanie">Описание</a></li>
                        <li><a href="/o-produkte#dokumentatsiya">Нормативная документация</a></li>
                        <li><a href="/o-produkte#stati">Научные статьи</a></li>
                        <li><a href="/o-produkte#otzyvy">Практика применения/Отзывы</a></li>
                        <li><a href="/o-produkte#voprosy">Вопросы и ответы</a></li>
                    </ul>
                </li>
                <li><a href="/oblast-primeneniya">Области применения</a></li>
                <li><a href="/otrasli-promyshlennosti">Отрасли промышленности</a></li>
                <li><a href="/biblioteka">Библиотека</a></li>
                <li><a href="/news">Новости</a></li>
                <li><a href="/referentsii">Референции</a></li>
                <li><a href="/oprosnyy-list">Опросный лист</a></li>
                <li><a href="/contacts">Контакты</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main id="main-content">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer id="footer">
            <div class="footer-content">
                <div>
                    <h4>HELAMIN®</h4>
                    <p>Инновационные решения для водоподготовки</p>
                </div>
                <div>
                    <h4>Контакты</h4>
                    <p>Телефон: +7 (495) 795-36-05</p>
                    <p>Email: info@helamin.ru</p>
                </div>
                <div>
                    <h4>Навигация</h4>
                    <p><a href="/o-produkte">О продукте</a></p>
                    <p><a href="/contacts">Контакты</a></p>
                </div>
            </div>
            <div id="footer-bottom">
                <p>&copy; {{ date('Y') }} HELAMIN. Все права защищены.</p>
            </div>
        </footer>
    </div>
    
    @stack('scripts')
</body>
</html>
