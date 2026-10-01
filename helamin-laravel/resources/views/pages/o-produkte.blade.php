@extends('layouts.app')

@section('title', 'О продукте — Helamin')

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
            <h1 class="content-area__title">О продукте HELAMIN<sup>&reg;</sup></h1>

            <p><strong>HELAMIN<sup>&reg;</sup></strong> — инновационный ингибитор коррозии и&nbsp;отложений для&nbsp;водно-паровых систем. Разработан компанией Helamin Technology Holding SA (Швейцария).</p>

            <p>Продукт обеспечивает эффективную защиту от&nbsp;коррозии и&nbsp;отложений в&nbsp;контурах воды и&nbsp;пара, теплофикационных сетях, системах горячего водоснабжения. Является альтернативой традиционному кондиционированию гидразином, аммиаком и&nbsp;фосфатами.</p>

            <p>Выберите подраздел в&nbsp;боковом меню для получения подробной информации.</p>
        </article>
    </div>
</section>
@endsection
