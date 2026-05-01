@extends('layouts.app')

@section('title', 'Контакты — Helamin')

@section('content')
<section class="main-content">
    <div class="container">
        <article class="content-area">
            <h1 class="content-area__title">Контакты</h1>

            <div class="contacts-text">

                <p><strong>Разработчик и единственный патентодержатель марки Хеламин:</strong><br>
                Helamin Technology Holding SA, Швейцария (<a href="https://www.helamin.com/" target="_blank" rel="noopener">www.helamin.com</a>)</p>

                <p><strong>Производитель реагентов Хеламин:</strong><br>
                Helamin France SaRL, Франция</p>

                <p><strong>Исключительный импортёр в страны таможенного союза:</strong><br>
                ООО &laquo;Хеламин Проект&raquo;, Россия (<a href="{{ url('/') }}">www.helamin.ru</a>)<br>
                ОГРН 1087746447249<br>
                Серия 77 №&thinsp;010261917 от 01.04.2008<br>
                Выдано Межрайонной инспекцией ФНС №&thinsp;46 по г.&nbsp;Москве<br>
                ИНН / КПП: 7719675703 / 771801001<br>
                Адрес: 107023, г.&nbsp;Москва, Семёновский переулок, д.&nbsp;15</p>

                <p><strong>Телефон:</strong> <a href="tel:+74957953605">+7 (495) 795-36-05</a> / <a href="tel:+74957953606">06</a> / <a href="tel:+74957953607">07</a></p>

                <p><strong>Эл.&nbsp;почта:</strong> <a href="mailto:info@helamin.ru">info@helamin.ru</a></p>

            </div>

        </article>
    </div>
</section>
@endsection
