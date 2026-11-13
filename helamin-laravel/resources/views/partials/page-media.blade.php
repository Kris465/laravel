@if(!empty($page->imageUrls()))
    <div class="page-gallery">
        @foreach($page->imageUrls() as $url)
            <figure class="page-gallery__item">
                <img src="{{ $url }}" alt="{{ $page->title }}" loading="lazy">
            </figure>
        @endforeach
    </div>
@endif

@if(!empty($page->documentLinks()))
    <section class="page-documents">
        <h2 class="page-documents__title">Документы</h2>
        <ul class="page-documents__list">
            @foreach($page->documentLinks() as $document)
                <li><a href="{{ $document['url'] }}" download>{{ $document['name'] }}</a></li>
            @endforeach
        </ul>
    </section>
@endif
