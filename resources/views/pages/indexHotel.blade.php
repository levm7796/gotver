@extends('layout')
@section('title')
    {{ $hotel->title }}
@endsection
@section('description')
    {{ $hotel->description }}
@endsection
@section('head-end')
    <script src="https://api-maps.yandex.ru/2.1/?apikey=39d99a70-dcc3-427d-9e95-c1e01263fb84&amp;lang=ru_RU"></script>
@endsection
@section('body-end')
    @include('modals.tell-about', ['name' => $hotel->name, 'url' => url()->current()])
@endsection
@section('content')
    @php
        $breadcrumbs = [
            ['url' => '/', 'name' => 'Главная'],
            ['url' => $hotel->location->myUrl() , 'name' => $hotel->location->name],
            ['url' => $hotel->hub->myUrl() , 'name' => $hotel->hub->name],
            ['name' => $hotel->name]
        ];
    @endphp
    @if(!isset($excludeBread))
        @include('blocks.bread-crumbs')
    @endif
    <div class="wrapper">
            <article id="article"  @if($favorite) class="card-object item-favorite is-favorite" @else class="card-object item-favorite" @endif>
                <div class="container">
                    <h1 class="card-object__title">{{ $hotel->name }}</h1>
                    <div class="card-object__grid">
                        <div class="card-object__images-wrapper">
                            <div class="card-object__images">
                                <div class="card-object__image is-show">
                                    <picture>
                                        <source type="image/webp"><img src="{{$imgs[0]['img']}}" width="456" height="278" alt="виды отеля" loading="eager">
                                    </picture>
                                </div>
{{--                                <div class="card-object__image is-show">--}}
{{--                                    <picture>--}}
{{--                                        <source type="image/webp" srcset="/img/content/cards/card-01.webp, /img/content/cards/card-01@2x.webp 2x"><img src="/img/content/cards/card-01.png" srcset="/img/content/cards/card-01@2x.png 2x" width="456" height="278" alt="виды отеля" loading="eager">--}}
{{--                                    </picture>--}}
{{--                                </div>--}}
                                @for($i = 1; $i<count($imgs); $i++)
                                    <div class="card-object__image">
                                        <picture>
                                            <source type="image/webp"><img src="{{$imgs[$i]['img']}}" width="456" height="278" alt="виды" loading="eager">
                                        </picture>
                                    </div>
                                @endfor
{{--                                <div class="card-object__image">--}}
{{--                                    <picture>--}}
{{--                                        <source type="image/webp" srcset="/img/content/cards/card-03.webp, /img/content/cards/card-03@2x.webp 2x"><img src="/img/content/cards/card-03.png" srcset="/img/content/cards/card-03@2x.png 2x" width="456" height="278" alt="виды отеля" loading="eager">--}}
{{--                                    </picture>--}}[
{{--                                </div>--}}
                            </div>
                            <div class="card-object__images-preview">
                                <button class="card-object__image-button is-show" type="button" data-preview="">
                                    <picture>
                                        <source type="image/webp"><img src="{{$imgs[0]['img']}}" width="456" height="278" alt="виды отеля" loading="eager">
                                    </picture>
                                </button>
                                @for($i = 1; $i<3; $i++)
                                    @if(isset($imgs[$i]))
                                        <button class="card-object__image-button" type="button" data-preview="">
                                            <picture>
                                                <source type="image/webp"><img src="{{$imgs[$i]['img']}}" width="456" height="278" alt="виды отеля" loading="eager">
                                            </picture>
                                        </button>
                                    @endif
                                @endfor

{{--                                <button class="card-object__image-button" type="button" data-preview="">--}}
{{--                                    <picture>--}}
{{--                                        <source type="image/webp" srcset="/img/content/cards/card-03.webp, /img/content/cards/card-03@2x.webp 2x"><img src="/img/content/cards/card-03.png" srcset="/img/content/cards/card-03@2x.png 2x" width="456" height="278" alt="виды отеля" loading="eager">--}}
{{--                                    </picture>--}}
{{--                                </button>--}}
                                @if(count($imgs) > 3)
                                    <button class="card-object__image-button card-object__image-button--count" type="button" data-open-modal="card-slider">
                                        <picture>
                                            <source type="image/webp"><img src="{{$imgs[3]['img']}}" width="456" height="278" alt="виды отеля" loading="eager">
                                        </picture><span>+{{count($imgs) - 3}}</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="card-object-features">
                            <div class="card-object-features__top-wrapper">
                                <div class="card-object-features__map">
                                    <div class="card-object-features__map-picture">
                                        <picture>
                                            <source type="image/webp" srcset="/img/content/location-object.webp, /img/content/location-object@2x.webp 2x"><img src="/img/content/location-object.png" srcset="/img/content/location-object@2x.png 2x" width="64" height="64" alt="иконка карты" loading="eager">
                                        </picture>
                                    </div>
                                    <div class="card-object-features__map-info">
                                        <p class="card-object-features__map-text">{{ $hotel->address }}</p>
                                        <a class="card-object-features__link" href="#map">Посмотреть на карте</a>
                                    </div>
                                </div>
                                <div class="card-object-features__items">
                                    @if(isset($places))
                                        @foreach($places as $place)
                                            <div class="card-object-features__item">
                                                <svg width="24" height="24" aria-hidden="true">
                                                    <use xlink:href="/img/sprite.svg#{{$place->icon}}"></use>
                                                </svg><span>{{$place->text}}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div><a class="card-object-features__link" href="#readom">Больше интересного рядом</a>
                            </div>
                            <div class="card-object-features__bottom-wrapper">
                                <div class="card-object-features__items-more">
                                    @if(isset($options))
                                        @foreach($options as $option)
                                            <div class="card-object-features__item-more">
                                                <svg width="20" height="20" aria-hidden="true">
                                                    <use xlink:href="/img/sprite.svg#{{$option['ico']}}"></use>
                                                </svg><span>{{$option['content']}}</span>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                                <div class="card-object-features__buttons">
                                    @if(!empty($hotel->reservation))
                                    <a class="main-btn" href="{{ route('statisticRedirect',
                                            ['hotelId' => $hotel->id,
                                            'redirect' => base64_encode($hotel->reservation)]) }}"><span>Забронировать</span>
                                        <svg width="40" height="40" aria-hidden="true">
                                            <use xlink:href="/img/sprite.svg#arrow-black"></use>
                                        </svg>
                                    </a>
                                    @endif
                                    <button class="action-item" type="button" data-favorite="article" onclick="favorite('{{$hotel->getTable()}}', {{$hotel->id}})"><span class="action-item__icon">
                        <svg width="24" height="24" aria-hidden="true">
                          <use xlink:href="/img/sprite.svg#heart"></use>
                        </svg></span>
                                    </button>
                                    <button class="action-item" type="button" data-open-modal="tell-about"><span class="action-item__icon">
                        <svg width="24" height="24" aria-hidden="true">
                          <use xlink:href="/img/sprite.svg#share"></use>
                        </svg></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-object__description">
                            <p class="card-object__title-h2">Описание</p>
                            <p class="card-object__description-text">
                                {!! $hotel->seo_text !!}
                            </p>
                            <div class="card-object__description-contacts">
                                <h3 class="card-object__description-contacts-title">Контакты <span>{{ $hotel->name }}</span></h3>
                                <div class="card-object__description-contacts-content">
                                    <p class="card-object__description-contacts-text">
                                        {!! $hotel->contact_description !!}
                                    </p>
                                    <div class="card-object__description-contacts-info-group">
                                        <script type="text/javascript">
                                            function phoneClick(){
                                                fetch( '{{ route('statisticPhone', $hotel->id) }} ')
                                            }
                                        </script>
                                        <a onClick="phoneClick()" class="card-object__description-contacts-link card-object__description-contacts-link--bold" href="tel:+{{$phoneNumber}}">
                                            <svg width="24" height="24" aria-hidden="true">
                                                <use xlink:href="/img/sprite.svg#phone"></use>
                                            </svg><span>{{$phone}}</span>
                                        </a>

                                        <a class="card-object__description-contacts-link" href="mailto:{{$hotel->email}}">
                                            <svg width="24" height="24" aria-hidden="true">
                                                <use xlink:href="/img/sprite.svg#mail"></use>
                                            </svg><span>{{$hotel->email}}</span>
                                        </a>

                                        <a class="card-object__description-contacts-link" href="{{ route('statisticRedirect',
                                            ['hotelId' => $hotel->id,
                                            'redirect' => base64_encode($hotel->website)]) }}">
                                            <svg width="24" height="24" aria-hidden="true">
                                                <use xlink:href="/img/sprite.svg#web"></use>
                                            </svg><span>{{$hotel->website}}</span>
                                        </a>

                                        <div class="card-object__description-contacts-social">
                                            @if(isset($social) && count($social) >= 1)
                                                @foreach($social as $item)
                                                    <a href="{{$item['link']}}">
                                                        <svg width="24" height="24" aria-hidden="true">
                                                            <use xlink:href="/img/sprite.svg#{{$item['icon']}}"></use>
                                                        </svg><span class="visually-hidden">{{$item['icon']}}</span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('parts.card-object-comments', ['comments' => $hotel->commentsLimit(3), 'itemId' => $hotel->id, 'tableName' => $hotel->getTable()])
                    </div>
                    <div id="map" style="">
                    </div>
            </article>
            <section class="places-nearby" id="readom">
                <div class="container">
                    <div class="main-title">
                        <h2>Места рядом</h2>
                    </div>
                    <div class="articles-slider">
                        <div class="articles-slider__container swiper swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden">
                            <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);" id="swiper-wrapper-59f5434b771bbc68" aria-live="polite">
                                @if(Auth::check())
                                    @php
                                        $user = Auth::user();
                                        $newsFavorites = optional($user->favorites)['news'];
                                    @endphp
                                @endif
                                @foreach($hotel->someArticles() as $new)
                                    @include('parts.news-news-item', ['new' => $new, 'newsFavorites' => !empty($newsFavorites) ? $newsFavorites : null])
                                @endforeach
                            </div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                        <div class="articles-slider__slider-buttons">
                            <div class="slider-button swiper-button-prev swiper-button-disabled" tabindex="-1" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-59f5434b771bbc68" aria-disabled="true">
                                <svg width="5" height="9" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#arrow-nav"></use>
                                </svg>
                            </div>
                            <div class="slider-button swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-59f5434b771bbc68" aria-disabled="false">
                                <svg width="5" height="9" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#arrow-nav"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="tags-additional">
                <div class="container">
                    <div class="main-title">
                        <h2>Дополнительные теги</h2>
                    </div>
                    <div class="tags-additional__wrapper">
                        @foreach($hotel->getAllTags() as $key => $tg)
                        <a class="tag-item" href="#" data-tag="{{ $tg->name }}" data-color="{{ ['red', 'green', 'purple', 'blue'][$key % 4] }}">
                            <svg width="16" height="16" aria-hidden="true">
                                <use xlink:href="/img/sprite.svg#tag"></use>
                            </svg><span>{{ $tg->name }}</span>
                        </a>
                        @endforeach
                        <a class="main-btn" href="{{ $hotel->location->myUrl() }}"><span>Все туристические места {{ $hotel->location->name }}</span>
                            <svg width="40" height="40" aria-hidden="true">
                              <use xlink:href="/img/sprite.svg#arrow-black"></use>
                            </svg>
                        </a>
                    </div>
                </div>
            </section>
    </div>
    <script>
        function favorite(table, id) {
            // table = table.id
            console.log(table, id)
            let csrf = document.querySelector('meta[name="csrf-token"]').content;
            axios.post(`/hotel/favorite/${table}/${id}`, {
                headers: {
                    'X-CSRF-Token': csrf
                }
            }).then(res=>{
                if(res.data) {
                    document.getElementById('article').classList.add('is-favorite')
                } else {
                    document.getElementById('article').classList.remove('is-favorite')
                }
            })
        }
    </script>


@if(!empty($hotel->coordinates))
<Script>
    const map = document.querySelector('#map');

    ymaps.ready(function () {
        var myMap = new ymaps.Map('map', {
            center: [{{ $hotel->coordinates }}],
            zoom: 16,
            controls: []
        },
        {
            suppressMapOpenBlock: true
        });

        var myPlacemark = new ymaps.Placemark([{{ $hotel->coordinates }}], {
            hintContent: '{{ $hotel->name }}',
            // balloonContent: 'Viewpoint Hotel. <br> Садовническая набережная, 7'
        },
        {
            iconLayout: 'default#image',
            iconImageHref: '/img/svg/Yandex_Maps_icon.svg',
            iconImageSize: [30, 30],
            iconImageOffset: [-15, -30]
        });

        myMap.geoObjects.add(myPlacemark)
    });
</Script>
@endif

@endsection
