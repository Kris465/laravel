@extends('layouts.app')

@section('title', 'Описание — Helamin')

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
            <h1 class="content-area__title">Описание</h1>
            <p>Страница в разработке.</p>
        </article>
    </div>
</section>
@endsection
