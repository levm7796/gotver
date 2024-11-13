@extends('layout')

@section('title')
    {{ optional($settings)['title'] }}
@endsection
@section('description')
    {{ optional($settings)['description'] }}
@endsection

@section('head-end')
    @if($article['show'])
        <script src="https://api-maps.yandex.ru/2.1/?apikey=39d99a70-dcc3-427d-9e95-c1e01263fb84&amp;lang=ru_RU"></script>
    @endif
@endsection

@section('body-end')
@endsection

@section('content')
    @php
        $breadcrumbs = [['url' => '/', 'name' => 'Главная'], ['name' => 'Новости']];
    @endphp
    <style>
        main .bread-crumbs {
            margin-bottom: 15px;
        }
    </style>
    @include('blocks.bread-crumbs')
    <section class="news">
        <div class="container">
            <div class="main-title main-title--column">
                <h1>{{ optional($settings)['h1'] }}</h1>
                <p class="main-title__description">
                    {!! optional($settings)['seo_text'] !!}
                </p>
            </div>
            <div class="articles-slider">
                <div class="articles-slider__container swiper">
                    <div class="swiper-wrapper">
                        @if(Auth::check())
                            @php
                                $user = Auth::user();
                                $newsFavorites = optional($user->favorites)['news'];
                            @endphp
                        @endif
                        @foreach($news as $new)
                            @include('parts.news-news-item', ['new' => $new, 'newsFavorites' => !empty($newsFavorites) ? $newsFavorites : null])
                        @endforeach
                    </div>
                </div>
                <div class="articles-slider__slider-buttons">
                    <div class="slider-button swiper-button-prev">
                        <svg width="5" height="9" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#arrow-nav"></use>
                        </svg>
                    </div>
                    <div class="slider-button swiper-button-next">
                        <svg width="5" height="9" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#arrow-nav"></use>
                        </svg>
                    </div>
                </div>
            </div>
            @include('parts.hub-filter-panel_and_grid-container', ['blockTags' => $tags, 'blockHotels' => $allNews, 'hideSort' => true, 'hideJS' => true, 'hideBtnJs' => true])
        </div>
    </section>
    <div class="container">
        <section class="text-content">
            <h2>{{ optional($settings)['h2'] }}</h2>
            {!! optional($settings)['seo_text2'] !!}
        </section>
    </div>
    @if($article['show'])
    <style>
        .card-object__comments{
            margin-top: 80px;
        }
    </style>
        @include('parts.news-content', [
                                        'news' => $article['article'],
                                        'tags' => $article['tags'],
                                        'comments' => $article['comments'],
                                        'blocks' => $article['blocks'],
                                        ])
    @endif
    <script>
        // let filterState = null;
        let tagId = null;
        let page = 1;
        document.addEventListener('click', function(event) {
            // if (event.target.closest('.custom-select__item')) {
            //     filterState = event.target.getAttribute('data-select-value').split('-')?.[1]
            //     fetchHotels(event.target.closest('.container'));
            // }
            if (event.target.closest('.tag-item')) {
                handleTagClick(event.target.closest('.tag-item'));
            }
            if (event.target.closest('.button-more')) {
                handleMoreClick();
            }
            function handleTagClick(btn){
                page = null
                console.log('handleTagClick', btn)
                btn.closest('.tag-panel').querySelector('.tag-item.active')?.classList?.remove('active')
                btn.classList.add('active')
                tagId = btn.getAttribute('tagid')
                fetchHotels(btn.closest('.container'));
            }
            function handleMoreClick(){
                page++
                fetchHotels();
            }
            function fetchHotels(){
                const data = {
                    // filterState,
                    tagId,
                };
                const options = {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify(data)
                };
                // console.log('/news/news-sort?page='+page)
                fetch('/news/news-sort?page='+page, options)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if(data.status == 200){
                            if(page){
                                document.querySelector('.grid-container__inner').innerHTML += data.list
                            } else {
                                document.querySelector('.grid-container__inner').innerHTML = data.list
                                page = 1
                            }
                            document.querySelector('.button-more').style.display = data?.hasMorePages ? 'block' : 'none';
                        }
                    })
                    .catch(error => {
                        console.log('Произошла ошибка:', error);
                    });
            }
        });
    </script>
@endsection
