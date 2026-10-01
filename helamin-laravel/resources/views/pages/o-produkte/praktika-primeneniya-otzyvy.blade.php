@extends('layouts.app')

@section('title', 'Практика применения / Отзывы — Helamin')

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
            <h1 class="content-area__title">Практика применения / Отзывы</h1>

            <p>HELAMIN<sup>&reg;</sup> успешно применяется на&nbsp;объектах энергетики, промышленности и&nbsp;ЖКХ по&nbsp;всей России и&nbsp;странам СНГ.</p>

            <p><em>Раздел находится в&nbsp;разработке. Скоро здесь будут опубликованы кейсы и&nbsp;отзывы.</em></p>
            <p>По&nbsp;вопросам обращайтесь в&nbsp;<a href="{{ url('/contacts') }}">контактный отдел</a>.</p>
        </article>
    </div>
</section>
@endsection
