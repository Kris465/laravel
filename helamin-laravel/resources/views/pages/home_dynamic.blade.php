@extends('layouts.app')

@section('title', 'Helamin — Средства для водоподготовки и защиты от коррозии')
@section('meta_description', $page->meta_description ?? '')

@section('content')
<section class="hero">
    <div class="hero__content container">
        <div class="hero__left">
            <img src="{{ url('/images/logo-helamin.png') }}" alt="HELAMIN" class="hero__logo">
        </div>

        <div class="hero__center">
            <h1 class="hero__title hero__title--red">HELAMIN<span class="hero__reg">&reg;</span></h1>
        </div>

        <div class="hero__right">
            <div class="hero__contacts">
                <a href="tel:+74957953605">+7 (495) 795-36-05</a>
                <a href="mailto:info@helamin.ru">info@helamin.ru</a>
            </div>
        </div>
    </div>
</section>

@if(isset($page))
<section class="main-content">
    <div class="container">
        <article class="content-area">
            {{ $page->renderedContent() }}
        </article>
    </div>
</section>
@endif

@endsection