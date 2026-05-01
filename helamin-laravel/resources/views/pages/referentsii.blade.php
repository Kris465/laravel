@extends('layouts.app')

@section('title', 'Референции — Helamin')

@section('content')
<section class="main-content">
    <div class="container">
        <article class="content-area">
            <h1 class="content-area__title">Референции</h1>

            <p>HELAMIN<sup>&reg;</sup> успешно применяется на&nbsp;объектах энергетики, промышленности и&nbsp;ЖКХ по&nbsp;всей России и&nbsp;странам СНГ. Среди заказчиков — крупнейшие генерирующие, нефтегазовые и&nbsp;промышленные компании.</p>

            {{-- ============================
                 РАЗДЕЛ 1: НА ЭНЕРГЕТИКЕ
                ============================ --}}
            <h2 class="ref-section-title">На энергетике</h2>

            <ul class="ref-list">
                <li><a href="http://enel.ru/" target="_blank" rel="noopener">Enel</a></li>
                <li><a href="http://www.e4group.ru/" target="_blank" rel="noopener">Группа Э4</a></li>
                <li><a href="http://www.interrao.ru/" target="_blank" rel="noopener">Интер РАО</a></li>
                <li><a href="http://www.quadra.ru/" target="_blank" rel="noopener">Квадра</a></li>
                <li><a href="http://www.kgk-kurgan.ru/" target="_blank" rel="noopener">Курганская генерирующая компания</a></li>
                <li><a href="http://www.votgk.ru/" target="_blank" rel="noopener">ВОТГК</a></li>
                <li><a href="http://www.lukoil.ru/" target="_blank" rel="noopener">Лукойл</a></li>
                <li><a href="http://www.ogk2.ru/" target="_blank" rel="noopener">ОГК-2</a></li>
                <li><a href="http://www.rosneft.ru/" target="_blank" rel="noopener">Роснефть</a></li>
                <li><a href="http://www.slavneft.ru/" target="_blank" rel="noopener">Славнефть</a></li>
                <li><a href="http://www.tgc-2.ru/" target="_blank" rel="noopener">ТГК-2</a></li>
            </ul>

            {{-- ============================
                 РАЗДЕЛ 2: НА ПРОМЫШЛЕННОСТИ
                ============================ --}}
            <h2 class="ref-section-title">На промышленности</h2>

            <ul class="ref-list">
                <li><a href="http://vti.ru/" target="_blank" rel="noopener">ВТИ (Всероссийский теплотехнический институт)</a></li>
                <li><a href="http://mpei.ru/" target="_blank" rel="noopener">МЭИ (Московский энергетический институт)</a></li>
                <li><a href="http://www.ckti.ru/" target="_blank" rel="noopener">ЦКТИ (Центральный котлотурбинный институт)</a></li>
                <li><a href="http://www.orgres-f.ru/" target="_blank" rel="noopener">Оргрес</a></li>
                <li>НИИ ККЦ</li>
            </ul>

            <div class="ref-note">
                <p><em>Полный перечень референций доступен по&nbsp;запросу. Для получения подробной информации, пожалуйста, <a href="{{ url('/contacts') }}">свяжитесь с&nbsp;нами</a>.</em></p>
            </div>

        </article>
    </div>
</section>
@endsection

@push('styles')
<style>
.ref-section-title {
  font-size: 1.375rem;
  font-weight: 700;
  color: var(--c-text);
  margin: 2rem 0 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid var(--c-border);
}

.ref-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: grid;
  grid-template-columns: 1fr;
  gap: 0.5rem;
}

@media (min-width: 600px) {
  .ref-list {
    grid-template-columns: 1fr 1fr;
  }
}

@media (min-width: 900px) {
  .ref-list {
    grid-template-columns: 1fr 1fr 1fr;
  }
}

.ref-list li {
  padding: 0.625rem 0.75rem;
  background: var(--c-bg);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-sm);
  font-size: 0.875rem;
  transition: var(--transition);
}

.ref-list li:hover {
  border-color: var(--c-primary);
  background: var(--c-primary-light);
}

.ref-list a {
  color: var(--c-primary);
  text-decoration: none;
  font-weight: 500;
}

.ref-list a:hover {
  text-decoration: underline;
}

.ref-note {
  margin-top: 2.5rem;
  padding: 1.25rem;
  background: var(--c-primary-light);
  border-radius: var(--radius);
  font-size: 0.875rem;
  color: var(--c-text-muted);
  line-height: 1.6;
}

.ref-note a {
  color: var(--c-primary);
  text-decoration: underline;
}

.ref-note a:hover {
  color: var(--c-primary-dark);
}
</style>
@endpush
