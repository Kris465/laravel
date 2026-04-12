<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="windows-1251">
    <meta name="viewport" content="width=1220">
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="Helamin">
    <meta name="description" content="Helamin - инновационная технология водоподготовки">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <title>@yield('title', 'HELAMIN')</title>
    
    <!-- Original CSS -->
    <link href="{{ asset('css/template.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('css/common.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('css/colors.css') }}" type="text/css" rel="stylesheet">
</head>
<body>
    <div id="page-wrapper">
        <div id="panel"></div>
        
        <!-- Header -->
        <div id="headers">
            <div id="header">
                <div class="slogan">
                    <img width="309" alt="Без гидразина" src="{{ asset('images/logos/568b435e3efb2e5fd1124888dea00616.png') }}" height="41">
                </div>
                <div class="slogan2">Без гидразина<br>Без фосфатов</div>
                <div class="phone">+7 (495) 795-36-05<br></div>
                <div class="mail">info@helamin.ru</div>
                
                <table id="logo">
                    <tr>
                        <td>
                            <a href="/" title="На главную страницу">
                                <img width="398" alt="HELAMIN logo" src="{{ asset('images/logos/f17e719bdd2fca1f9be6cd04603a885b.png') }}" height="55">
                            </a>
                        </td>
                    </tr>
                </table>
                
                <div class="search">
                    <div id="search">
                        <form action="/search">
                            <div class="rounded-box">
                                <div class="search-inner-box">
                                    <input type="text" name="q" value="ПОИСК..." onfocus="if (this.value == 'ПОИСК...') this.value = '';" onblur="if (this.value == '') this.value = 'ПОИСК...';" maxlength="50">
                                </div>
                            </div>
                            <div id="search-button">
                                <input type="submit" name="s" onfocus="this.blur();" value="Поиск" id="search-submit-button">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <div id="top-menus">
            <div id="top-menu">
                <div id="top-menu-inner">
                    <ul id="horizontal-multilevel-menu">
                        <li><a href="/o-produkte" class="root-item">О продукте</a>
                            <ul>
                                <li><a href="/o-produkte#opisanie">Описание</a></li>
                                <li><a href="/o-produkte#dokumentatsiya">Нормативная документация</a></li>
                                <li><a href="/o-produkte#stati">Научные статьи</a></li>
                                <li><a href="/o-produkte#otzyvy">Практика применения/Отзывы</a></li>
                                <li><a href="/o-produkte#voprosy">Вопросы и ответы</a></li>
                            </ul>
                        </li>
                        <li><a href="/news" class="root-item">Новости</a></li>
                        <li><a href="/oblast-primeneniya" class="root-item">Области применения</a>
                            <ul>
                                <li><a href="/oblast-primeneniya#kotly-vysokogo">Котлы высокого и сверхвысокого давления</a></li>
                                <li><a href="/oblast-primeneniya#kotly-nizkogo">Котлы низкого и среднего давления</a></li>
                                <li><a href="/oblast-primeneniya#kotly-utilizatory">Котлы утилизаторы</a></li>
                                <li><a href="/oblast-primeneniya#pgu">ПГУ</a></li>
                                <li><a href="/oblast-primeneniya#promyvka">Предпусковая отмывка и консервация</a></li>
                                <li><a href="/oblast-primeneniya#teplofikatsiya">Системы теплофикации</a></li>
                                <li><a href="/oblast-primeneniya#vodosnabzhenie">Системы горячего водоснабжения</a></li>
                            </ul>
                        </li>
                        <li><a href="/otrasli-promyshlennosti" class="root-item">Отрасли промышленности</a>
                            <ul>
                                <li><a href="/otrasli-promyshlennosti#teploenergetika">Тепло- и электроэнергетика</a></li>
                                <li><a href="/otrasli-promyshlennosti#neftepererabotka">Нефтеперерабатывающая промышленность</a></li>
                                <li><a href="/otrasli-promyshlennosti#neftekhimiya">Нефтехимическая промышленность</a></li>
                                <li><a href="/otrasli-promyshlennosti#udobreniya">Азотная промышленность и производство удобрений</a></li>
                                <li><a href="/otrasli-promyshlennosti#metallurgiya">Черная и цветная металлургия</a></li>
                                <li><a href="/otrasli-promyshlennosti#bumazhnaya">Целлюлозно-бумажная промышленность</a></li>
                                <li><a href="/otrasli-promyshlennosti#pishchevaya">Пищевая промышленность</a></li>
                                <li><a href="/otrasli-promyshlennosti#zhkkh">ЖКХ / Муниципальные образования</a></li>
                                <li><a href="/otrasli-promyshlennosti#drugie">Другие виды промышленности</a></li>
                            </ul>
                        </li>
                        <li><a href="/biblioteka" class="root-item">Библиотека</a>
                            <ul>
                                <li><a href="/biblioteka#normativnaya">Нормативная документация</a></li>
                                <li><a href="/o-produkte#stati">Научные статьи</a></li>
                                <li><a href="/o-produkte#otzyvy">Практика применения/Отзывы</a></li>
                                <li><a href="/o-produkte#voprosy">Вопросы и ответы</a></li>
                            </ul>
                        </li>
                        <li><a href="/oprosnyy-list" class="root-item">Опросный лист</a></li>
                        <li><a href="/referentsii" class="root-item">Референции</a></li>
                        <li><a href="/contacts" class="root-item">Контакты</a></li>
                    </ul>
                    <div class="menu-clear-left"></div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div id="all">
            <div id="content-wrapper">
                <div id="content">
                    @yield('content')
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div id="footer">
            <div id="copyright">
                <p>&copy; {{ date('Y') }} HELAMIN. Все права защищены.</p>
                <p>ООО «Хеламин Русь»</p>
            </div>
        </div>
    </div>
</body>
</html>
