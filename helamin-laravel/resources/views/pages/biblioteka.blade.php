@extends('layouts.app')

@section('title', 'Библиотека — Helamin')

@section('content')
<section class="main-content">
    <div class="container">
        <article class="content-area">
            <h1 class="content-area__title">Библиотека</h1>

            <p>В&nbsp;данном разделе представлены материалы о&nbsp;продукте HELAMIN<sup>&reg;</sup>: научные статьи, нормативная документация, описания и&nbsp;практические рекомендации.</p>

            <p><em>Раздел находится в&nbsp;разработке. Скоро здесь будут доступны материалы для скачивания.</em></p>

            <p>По&nbsp;вопросам получения документации обращайтесь в&nbsp;<a href="{{ url('/contacts') }}">контактный отдел</a>.</p>
        </article>
    </div>
</section>
@endsection
