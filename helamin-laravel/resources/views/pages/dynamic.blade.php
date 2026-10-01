@extends('layouts.app')

@section('title', $page->title . ' — Helamin')

@section('content')
<section class="main-content">
    <div class="container">
        <article class="content-area">
            @if(isset($page))
                {!! $page->content !!}
            @else
                <h1 class="content-area__title">Страница не найдена</h1>
                <p>Контент для этой страницы ещё не создан.</p>
            @endif
        </article>
    </div>
</section>
@endsection