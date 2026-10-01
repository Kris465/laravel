@extends('layouts.app')

@section('title', 'Новости — Helamin')

@section('content')
<section class="main-content">
    <div class="container">
        <article class="content-area">
            <h1 class="content-area__title">Новости</h1>

            <p>В данном разделе представлены новости компании и&nbsp;информация о&nbsp;последних событиях.</p>

            <p><em>Раздел находится в&nbsp;разработке. Скоро здесь появятся актуальные новости.</em></p>

            <p>По&nbsp;вопросам сотрудничества обращайтесь в&nbsp;<a href="{{ url('/contacts') }}">контактный отдел</a>.</p>
        </article>
    </div>
</section>
@endsection
