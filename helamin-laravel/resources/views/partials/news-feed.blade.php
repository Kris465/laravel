@php($feedBlocks = $page->feedBlocks())

@if(!empty($feedBlocks))
    <section class="news-feed" aria-label="Лента новостей">
        @foreach($feedBlocks as $block)
            <article class="news-feed__item">
                <div class="news-feed__marker" aria-hidden="true"></div>

                <div class="news-feed__card">
                    @if($block['date'] !== '')
                        <time class="news-feed__date">{{ $block['date'] }}</time>
                    @endif

                    @if($block['image'])
                        <img class="news-feed__image"
                             src="{{ $block['image'] }}"
                             alt="{{ $block['title'] }}"
                             loading="lazy">
                    @endif

                    @if($block['title'] !== '')
                        <h2 class="news-feed__title">{{ $block['title'] }}</h2>
                    @endif

                    @if((string) $block['text'] !== '')
                        <div class="news-feed__text">{{ $block['text'] }}</div>
                    @endif

                    @if($block['link'])
                        <a class="news-feed__more" href="{{ $block['link'] }}">Подробнее &rarr;</a>
                    @endif
                </div>
            </article>
        @endforeach
    </section>
@endif
