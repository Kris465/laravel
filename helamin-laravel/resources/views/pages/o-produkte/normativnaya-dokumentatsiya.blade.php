@extends('layouts.app')

@section('title', 'Нормативная документация — Helamin')

@section('content')
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
            <h1 class="content-area__title">Нормативная документация</h1>

            <p>В&nbsp;данном разделе представлена нормативная документация на&nbsp;продукцию HELAMIN<sup>&reg;</sup>.</p>

            <ul class="content-list">
                <li>Паспорт безопасности (MSDS)</li>
                <li>Технические условия</li>
                <li>Сертификаты соответствия</li>
                <li>Разрешения и&nbsp;допуски</li>
            </ul>

            <p><em>Документы будут доступны для&nbsp;скачивания в&nbsp;ближайшее время.</em></p>
            <p>Для&nbsp;получения документации обращайтесь в&nbsp;<a href="{{ url('/contacts') }}">контактный отдел</a>.</p>
        </article>
    </div>
</section>
@endsection
