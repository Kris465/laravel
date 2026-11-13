@extends('layouts.app')

@section('title', $page->title . ' — Helamin')
@section('meta_description', $page->meta_description ?? '')

@section('content')
<section class="main-content">
    <div class="container">
        <article class="content-area">
            {{ $page->renderedContent() }}
        </article>

        @include('partials.page-media')
    </div>
</section>
@endsection