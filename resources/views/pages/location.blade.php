@extends('layout')

@section('title')
    {{ optional($settings)['title'] }}
@endsection
@section('description')
    {{optional($settings)['description'] }}
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
        $breadcrumbs = [['url' => '/', 'name' => 'Главная'], ['name' => $location->name]];
    @endphp
    @include('blocks.bread-crumbs')
    @php
        $img = optional($location->images())[0];
    @endphp
    <section class="intro" style="background-image: linear-gradient(rgba(39, 41, 46, .7), rgba(39, 41, 46, .7)), url({{ $img ? $img : '/img/content/tver-full.webp' }});">
        <div class="intro__info">
            <div class="container">
                <div class="intro__text">
                    <h1 class="intro__title">
                        @if(!empty($settings['h1']))
                            {!! $settings['h1'] !!}
                        @else
                            {{ $location->name }}
                        @endif
                    </h1>
                    <p class="intro__description">{{ $location->seo_text }}</p>
                </div>
                <div class="categories-links swiper">
                    <div class="swiper-wrapper">
                        @foreach($location->hubs as $hub)
                        <a class="main-btn main-btn--category swiper-slide" href="{{ $hub->myUrl() }}"><span>{{ $hub->name }}</span>
                            <svg width="40" height="40" aria-hidden="true">
                                <use xlink:href="/img/sprite.svg#{{ $hub->icon }}"></use>
                            </svg>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- @if($article['show'])
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
                                        'h1Normal' => true,
                                        ])
    @endif --}}


    <section class="plan-ideal-tour">
        <div class="container">
            <div class="main-title">
                <h2>@if(!empty($settings['titleTravel'])){!! $settings['titleTravel'] !!}@else
                        Спланируйте своё идеальное путешествие
                    @endif</h2>
                <div class="main-title__description">@if(!empty($settings['descriptionTravel'])){!! $settings['descriptionTravel'] !!} @else
                        В рамках спецификации современных стандартов, акционеры крупнейших компаний освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы, разумеется, в равной степени предоставлены сами себе.
                    @endif</div>
            </div>
            <div class="tag-panel swiper" data-showmore="items" data-showmore-media="768,min">
                <div class="tag-panel__wrapper swiper-wrapper" data-showmore-content="1">
                    @foreach($uniqueLocationTags as $key => $tag)
                        <a class="tag-item swiper-slide @if($key == 0) active @endif " href="javascript:void(0)" data-tag="{{ $tag->name }}" data-color="{{ ['red', 'green', 'purple', 'blue'][$tag->id % 4] }}"
                            tagid="{{ $tag->id }}"
                        >
                            <svg width="16" height="16" aria-hidden="true">
                                <use xlink:href="/img/sprite.svg#tag"></use>
                            </svg><span>{{ $tag->name }}</span>
                        </a>
                        @endforeach
                </div>
                <button class="btn-showmore-round" type="button" hidden
                    data-showmore-button><span></span><span></span></button>
            </div>
            <div class="plan-ideal-tour__slider">
                <div class="card-grid-to-slider swiper">
                    <div class="card-grid-to-slider__wrapper swiper-wrapper">
                        @include('parts.location-card-grid-to-slider_instant-items',['tag' => $uniqueLocationTags[0] ?? null, 'hotels' => $selectedHotels])
                    </div>
                </div>
                <div class="plan-ideal-tour__slider-buttons">
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
            @if(!empty($uniqueLocationTags[0]))
            <a class="main-btn main-btn-mobile" href="{{ $uniqueLocationTags[0]->myUrl() }}"><span>Посмотреть всё</span>
                <svg width="40" height="40" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#arrow-black"></use>
                </svg>
            </a>
            @endif
        </div>
    </section>


    @if(optional($settings)['article_text'])
        <div class="container">
            <section class="text-content">
            {!! optional($settings)['article_text'] !!}
            </section>
        </div>
    @endif


    <section class="tag-search">
        <div class="container">
            <div class="main-title">
                <h2>@if(!empty($settings['titleTags']))
                        {!! $settings['titleTags'] !!}
                    @else
                        Теги, которые чаще всего ищут
                    @endif
                </h2>
                <div class="main-title__description">@if(!empty($settings['descriptionTags'])){!! $settings['descriptionTags'] !!} @else
                        В рамках спецификации современных стандартов, акционеры крупнейших компаний освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы, разумеется, в равной степени предоставлены сами себе.
                    @endif</div>
            </div>
            <div class="tag-search__wrapper">
                @foreach($tags as $tag)
                <a class="tag-item" href="#" data-tag="{{$tag->name}}"
                    data-color="purple">
                    <svg width="16" height="16" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#tag"></use>
                    </svg><span>{{$tag->name}}</span>
                </a>
                @endforeach

                {{-- <a class="main-btn" href="#"><span>Посмотреть всё</span>
                    <svg width="40" height="40" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#arrow-black"></use>
                    </svg>
                </a> --}}
            </div>
        </div>
    </section>

    <script>
        let tagId = null;
        document.addEventListener('click', function(event) {
            if (event.target.closest('.tag-item')) {
                handleTagClick(event.target.closest('.tag-item'));
            }
            function handleTagClick(btn){
                console.log('handleTagClick', btn)
                btn.closest('.tag-panel').querySelector('.tag-item.active')?.classList?.remove('active')
                btn.classList.add('active')
                tagId = btn.getAttribute('tagid')
                fetchHotels(btn.closest('.container'));
            }
            function fetchHotels(parentBlock){
                const data = {
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

                fetch('/location/hotels-filter', options)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if(data.status == 200){
                            parentBlock.querySelector('.card-grid-to-slider__wrapper').innerHTML = data.list
                            parentBlock.querySelector('.main-btn-mobile').href = parentBlock.querySelector('.card-grid-to-slider__wrapper').querySelector('.main-btn').href
                        }
                        console.log('Успешная авторизация:', data);
                    })
                    .catch(error => {
                        console.log('Произошла ошибка:', error);
                    });
            }
        });
        </script>
@endsection
