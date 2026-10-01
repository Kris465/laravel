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
            <h1 class="content-area__title">Описание продукта</h1>

            <p><strong>HELAMIN<sup>&reg;</sup></strong> представляет собой смесь поликарбоксилатов и&nbsp;поверхностно-активных насыщенных алкилполиаминов в&nbsp;сочетании с&nbsp;другими аминами различной степени летучести.</p>

            <ul class="content-list">
                <li>Эффективная защита от&nbsp;коррозии и&nbsp;отложений в&nbsp;контурах воды и&nbsp;пара</li>
                <li>Широкое применение для&nbsp;предпусковой отмывки и&nbsp;консервации</li>
                <li>Альтернатива традиционному кондиционированию гидразином, аммиаком и&nbsp;фосфатами</li>
                <li>Без гидразина, без фосфатов</li>
                <li>3-й класс опасности (малотоксичный)</li>
            </ul>

            <p><em>Подробная информация появится в&nbsp;ближайшее время.</em></p>
            <p>По&nbsp;вопросам обращайтесь в&nbsp;<a href="{{ url('/contacts') }}">контактный отдел</a>.</p>
        </article>
    </div>
</section>
@endsection
