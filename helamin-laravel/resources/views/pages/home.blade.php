@extends('layouts.app')

@section('title', 'Helamin — Средства для водоподготовки и защиты от коррозии')

@section('content')
<section class="hero">

    {{-- Основной контент hero — 3 колонки --}}
    <div class="hero__content container">
        <div class="hero__left">
            <div class="hero__logo-block">
                <div class="hero__logo-main">HTH</div>
                <div class="hero__logo-sub">Helamin Technology Holding</div>
            </div>
        </div>

        <div class="hero__center">
            <h1 class="hero__title">HELAMIN<span class="hero__reg">&reg;</span></h1>
            <p class="hero__subtitle">Инновационные ингибиторы коррозии и&nbsp;отложений</p>
            <p class="hero__subtitle-en">Pioneer in polyamines filming technology</p>

            <div class="hero__badges">
                <span>Без гидразина</span>
                <span>Без фосфатов</span>
            </div>

            <a href="{{ url('/o-produkte') }}" class="hero__cta">Подробнее о продукте</a>
        </div>

        <div class="hero__right">
            <div class="hero__contacts">
                <a href="tel:+74957953605">+7 (495) 795-36-05</a>
                <a href="mailto:info@helamin.ru">info@helamin.ru</a>
            </div>
        </div>
    </div>
</section>

{{-- Двухколоночный блок: сайдбар + контент --}}
<section class="main-content">
    <div class="container main-content__inner">
        <aside class="sidebar">
            <ul class="sidebar__menu">
                <li><a href="{{ url('/o-produkte/opisanie') }}" class="sidebar__link">Описание</a></li>
                <li><a href="{{ url('/o-produkte/normativnaya-dokumentatsiya') }}" class="sidebar__link">Нормативная документация</a></li>
                <li><a href="{{ url('/o-produkte/nauchnye-stati') }}" class="sidebar__link">Научные статьи</a></li>
                <li><a href="{{ url('/o-produkte/praktika-primeneniya-otzyvy') }}" class="sidebar__link">Практика применения / Отзывы</a></li>
                <li><a href="{{ url('/o-produkte/voprosy-i-otvety') }}" class="sidebar__link">Вопросы и ответы</a></li>
            </ul>
        </aside>

        <article class="content-area">
            <h1 class="content-area__title">Что такое HELAMIN®</h1>

            <p><strong>HELAMIN® — ХЕЛАМИН®</strong></p>
            <p><strong>Ингибиторы коррозии и отложений</strong></p>

            <ul class="content-list">
                <li>Эффективная защита от&nbsp;коррозии и&nbsp;отложений в&nbsp;контурах воды и&nbsp;пара, теплофикационных сетях, системах горячего водоснабжения;&nbsp;</li>
                <li>Широкое применение для&nbsp;предпусковой отмывки и&nbsp;консервации;</li>
                <li>Альтернатива традиционному кондиционированию гидразином, аммиаком и&nbsp;фосфатами</li>
            </ul>

            <p><strong>Преимущества ХЕЛАМИНа®</strong></p>
            <ul class="content-list">
                <li>Улучшение антикоррозийной стойкости металла за&nbsp;счёт преобразования в&nbsp;защитный слой оксидных плёнок магнетита с&nbsp;гидрофобной полиаминной плёнкой;</li>
                <li>Отмывка от&nbsp;существующих отложений в&nbsp;рабочем режиме;</li>
                <li>Снижение величины непрерывной продувки котлов (как&nbsp;следствие, экономия добавочной воды, стоков, реагентов и&nbsp;топлива);</li>
                <li>Простота дозировки и&nbsp;хранения малотоксичного реагента (3‑й класс опасности);</li>
                <li>Упрощение химического контроля качества теплоносителя;</li>
                <li>Не&nbsp;требуется проведения дополнительных мероприятий по&nbsp;консервации оборудования при&nbsp;выводе его&nbsp;в&nbsp;резерв или&nbsp;ремонт на&nbsp;срок до&nbsp;6&nbsp;месяцев.</li>
                <li>Богатый опыт применения в&nbsp;России / странах СНГ</li>
                <li>Нормативная документация и&nbsp;научно-исследовательская работа</li>
            </ul>

            <p><strong>Принципы действия</strong></p>
            <p><strong>HELAMIN®</strong> является смесью поликарбоксилатов и&nbsp;поверхностно-активных насыщенных алкилполиаминов в&nbsp;сочетании с&nbsp;другими аминами различной степени летучести.</p>

            <p>Использование <strong>HELAMIN®</strong> в&nbsp;качестве кондиционирующего средства в&nbsp;водяных и&nbsp;паровых системах связано с&nbsp;гаммой преимуществ перед&nbsp;продуктами, применяемыми в&nbsp;традиционной водоподготовке, когда&nbsp;зачастую используется несколько реагентов, вводимых в&nbsp;разные места технологической схемы и&nbsp;отслеживание нужного градиента их&nbsp;концентраций представляет собой достаточно сложную задачу.</p>

            <p>В&nbsp;котельной воде парогенераторов полиэлектролиты дают синэргистические взаимоусиливающие эффекты.</p>

            <p>Поликарбоксилат, как&nbsp;натриевая соль, вследствие гидролиза приводит к&nbsp;независимому от&nbsp;температуры подщелачиванию. В&nbsp;качестве полиэлектролита он, как&nbsp;слабокислый ионообменник, обладает большим сродством к&nbsp;двух- и&nbsp;трёхвалентным катионам. В&nbsp;результате образуются более стабильные соли кальция и&nbsp;железа, удаляемые продувкой котла. Соли жёсткости в&nbsp;стехиометрических пределах сохраняются в&nbsp;растворённом виде. Количества, превышающие эти&nbsp;пределы, секвестируются (отделяются) и&nbsp;суспендируются, т.е.&nbsp;предотвращается их&nbsp;кристаллизация, а&nbsp;значит и&nbsp;образование накипи.</p>

            <p>На&nbsp;металлических поверхностях оборудования полиамин склонен к&nbsp;образованию плёнки. Помимо антикоррозионного действия полиаминовая плёнка также предотвращает нарастание кристаллов карбоната кальция на&nbsp;поверхностях конструкционного материала, в&nbsp;особенности в&nbsp;области напряжённого теплообмена. Точно также предотвращается отложение продуктов коррозии, поступивших в&nbsp;котел, а&nbsp;уже имеющиеся отложения могут быть осторожно удалены. При&nbsp;использовании в&nbsp;парогенераторах, в&nbsp;сетях тёплой и&nbsp;горячей воды, в&nbsp;перегревателях и&nbsp;при&nbsp;эксплуатации турбин, а&nbsp;также в&nbsp;системах охлаждения, HELAMIN® эффективно, экономично и&nbsp;экологически чисто решает сложные проблемы коррозии и&nbsp;отложений. Программы кондиционирования HELAMIN® обеспечивают дополнительную безопасность и&nbsp;надёжность эксплуатации благодаря профилактической защите поверхностей.</p>

            <p>Более подробная информация по&nbsp;свойствам Хеламина и&nbsp;механизмам его&nbsp;действия в&nbsp;пароводяном тракте&nbsp;— в&nbsp;статье «<a href="{{ url('/o-produkte/nauchnye-stati') }}"><em>Свойства Хеламина и&nbsp;механизм его&nbsp;действия в&nbsp;пароводяном тракте</em>»</a></p>

            <p><strong>Производитель и поставщики:</strong></p>
            <ul class="content-list">
                <li>Разработчик и&nbsp;единственный патентодержатель марки Хеламин: Helamin Technology Holding SA, Швейцария (<a href="https://www.helamin.com/" target="_blank" rel="noopener">www.helamin.com</a>)</li>
                <li>Производитель реагентов Хеламин: Helamin France SaRL, Франция</li>
                <li>Исключительный импортёр в&nbsp;страны таможенного союза: ООО&nbsp;«Хеламин Проект», Россия (<a href="{{ url('/') }}">www.helamin.ru</a>)</li>
            </ul>

            <p><strong>Упаковка (Тара)</strong></p>
            <p>Реагенты Хеламин поставляются в&nbsp;невозвратных полиэтиленовых бочках весом нетто&nbsp;210&nbsp;кг и&nbsp;60&nbsp;кг. Все&nbsp;отверстия опломбированы. На&nbsp;таре нанесены краской название реагента и&nbsp;номер партии.</p>

            <figure class="content-figure">
                <div class="content-figure__images">
                    <img src="{{ url('/images/package-main.png') }}" alt="Бочка Хеламина BRW 150 H" loading="lazy">
                    <img src="{{ url('/images/package-close.png') }}" alt="Опломбированные отверстия бочки Хеламина" loading="lazy">
                </div>
                <figcaption>Фото. Бочка Хеламина BRW&nbsp;150&nbsp;H, объём&nbsp;— 60&nbsp;л. Опломбированные отверстия. Маркировка: название реагента, номер&nbsp;партии</figcaption>
            </figure>
        </article>
    </div>
</section>

@endsection
