<div id="news">
    <article class="article item-favorite">
        <div class="container">
            @if(!isset($h1Normal) || $h1Normal == false)
                <h1>{{ $news->name }}</h1>
            @else
                <h2>{{ $news->name }}</h2>
            @endif
            <div class="tag-panel swiper" data-showmore="items" data-showmore-media="768,min">
                <div class="tag-panel__wrapper swiper-wrapper" data-showmore-content="1" style="">
                    @php
                        $newElements = collect([$news->location, $news->hub]);
                        $tags = $newElements->merge($tags);
                    @endphp
                    @foreach ($tags as $key => $tag)
                        <a class="tag-item swiper-slide" href="{{ $tag['myUrl'] }}" data-tag="{{$tag['name']}}" data-color="{{ ['red', 'green', 'purple', 'blue'][$key % 4] }}">
                            <svg width="16" height="16" aria-hidden="true">
                                <use xlink:href="/img/sprite.svg#tag"></use>
                            </svg>
                            <span>{{ $tag['name'] }}</span>
                        </a>
                    @endforeach
                </div>
                <button class="btn-showmore-round" type="button" hidden=""
                    data-showmore-button=""><span></span><span></span></button>
            </div>
            <div class="article__grid">
                <div class="article__content-main">
                    <div class="article__content-aside">
                        <div class="article__chapters">
                            <p class="article__chapters-title">Содержание:</p>
                            <ul class="article__chapters-list">
                                @if(!is_null($blocks))
                                @foreach ($blocks as $key => $block)
                                    @php
                                        $h2Array = [];
                                        $html = $block['description'];
                                        $dom = new DOMDocument();
                                        @$dom->loadHTML('<?xml encoding="UTF-8">' .$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                                        $h2Elements = $dom->getElementsByTagName('h2');
                                        foreach ($h2Elements as $index => $h2) {
                                            $id = 'part-'.$block['id'].'-' . $index; // Создаем id
                                            $text = $h2->nodeValue; // Получаем текст элемента h2
                                            $h2->setAttribute('id', $id); // Устанавливаем id в элемент

                                            // Добавляем id и текст в массив
                                            $h2Array[$id] = $text;
                                        }
                                        $blocks[$key]['description'] = $dom->saveHTML();//htmlspecialchars($dom->saveHTML(), ENT_QUOTES, 'UTF-8');
                                    @endphp
                                    @if(strlen($block['name']) > 0)
                                        <li>
                                            <a class="article__chapters-link" href="#part-{{ $block['id'] }}">
                                                {{ $block['name'] }}
                                            </a>
                                        </li>
                                    @endif
                                    @foreach($h2Array as $id => $content)
                                        <li>
                                            <a class="article__chapters-link" href="#{{ $id }}">
                                                {{ $content }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="ad-banner"></div>
                    </div>
                    <div class="article__content-article">
                        @if(!empty($news->img))
                        <figure class="article__cover">
                            <picture>
                                {{--                                    <source type="image/webp" srcset="/img/content/article/article-01.webp, /img/content/article/article-01@2x.webp 2x"> --}}
                                <img src="{{ $news->img }}" width="936" height="540"
                                    alt="{{ $news->title }}" loading="eager">
                            </picture>
                        </figure>
                        @endif
                        <div
                            class="article__actions
                            @if (Auth::check())
                                @php
                                    $user = Auth::user();
                                    $newsFavorites = optional($user->favorites)['news'];
                                    $isFavorite = $newsFavorites ? $newsFavorites->contains($news->id) : false;
                                @endphp
                                {{ $isFavorite ? 'is-favorite' : '' }}
                            @endif
                               ">
                            <button onclick="
                                @if (Auth::check())
                                    favorite({{ $news->getTable() }}, {{ $news->id }})
                                @else
                                    modals.open('login-to-account')
                                @endif
                            " class="action-item"
                                type="button" @if (Auth::check())data-favorite="article"@endif><span class="action-item__icon">
                                    <svg width="24" height="24" aria-hidden="true">
                                        <use xlink:href="/img/sprite.svg#heart"></use>
                                    </svg></span><span class="action-item__text">Добавить в&nbsp;избранное</span>
                            </button>
                            <button class="action-item" type="button" data-open-modal="tell-about"><span
                                    class="action-item__icon">
                                    <svg width="24" height="24" aria-hidden="true">
                                        <use xlink:href="/img/sprite.svg#share"></use>
                                    </svg></span><span class="action-item__text">Рассказать друзьям</span>
                            </button>
                        </div>
                        <div class="ad-banner"></div>
                        @if(!is_null($blocks))
                        @foreach ($blocks as $block)
                            <div class="article__section" id="part-{{ $block['id'] }}">
                                @if(!empty($block['name']))
                                    <p>{{ $block['name'] }}</p>
                                @endif
                                {!! $block['description'] !!}
                            </div>
                            @if(!empty($block['img']))
                            <figure>
                                <picture>
                                    <img src="{{ $block['img'] }}" width="936" height="624"
                                        alt="фото Твери" loading="lazy">
                                </picture>
                                <figcaption>{{ $block['signature'] }}</figcaption>
                            </figure>
                            @endif
                        @endforeach
                        @endif
                        <div
                        class="article__actions
                            @if (Auth::check())
                                @php
                                    $user = Auth::user();
                                    $newsFavorites = optional($user->favorites)['news'];
                                    $isFavorite = $newsFavorites ? $newsFavorites->contains($news->id) : false;
                                @endphp
                                {{ $isFavorite ? 'is-favorite' : '' }}
                            @endif
                           ">
                            <button onclick="@if (Auth::check())
                                                favorite({{ $news->getTable() }}, {{ $news->id }})
                                            @else
                                                modals.open('login-to-account')
                                            @endif
                                            "
                                class="action-item" type="button" @if (Auth::check())data-favorite="article"@endif><span
                                    class="action-item__icon">
                                    <svg width="24" height="24" aria-hidden="true">
                                        <use xlink:href="/img/sprite.svg#heart"></use>
                                    </svg></span><span class="action-item__text">Добавить в&nbsp;избранное</span>
                            </button>
                            <button class="action-item" type="button" data-open-modal="tell-about"><span
                                    class="action-item__icon">
                                    <svg width="24" height="24" aria-hidden="true">
                                        <use xlink:href="/img/sprite.svg#share"></use>
                                    </svg></span><span class="action-item__text">Рассказать друзьям</span>
                            </button>
                        </div>
                    </div>
                </div>
                @include('parts.card-object-comments', ['comments' => $news->commentsLimit(3), 'itemId' => $news->id, 'tableName' => $news->getTable()])
            </div>
            <div class="article__content-footer">
                @if(!empty($news->coordinates))
                <div id="map"></div>
                @endif
                <div class="article__info-panel">
                    <div class="article__author"><span>Автор:</span><a href="#">{{ $news->user->name }},</a>
                        <time datetime="{{ $news->created_at }}">{{ AppHelper::instance()->formatDate($news->created_at)  }}</time>
                    </div>
                    <div class="activity-panel">
                        @if ($news->views)
                            <div class="activity-panel__item">
                                <svg width="20" height="20" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#eye"></use>
                                </svg><span>{{ $news->viewsCount }}</span>
                            </div>
                        @endif
                        @if ($news->likes)
                            <div class="activity-panel__item">
                                <svg width="20" height="20" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#like"></use>
                                </svg><span>{{ $news->favoritesCount }}</span>
                            </div>
                        @endif
                        @if ($news->comments)
                            <div class="activity-panel__item">
                                <svg width="20" height="20" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#comment"></use>
                                </svg><span>{{ $news->commentsCount }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
    </article>
</div>
@if(!empty($news->coordinates))
<Script>
    const map = document.querySelector('#map');

    ymaps.ready(function () {
        var myMap = new ymaps.Map('map', {
            center: [{{ $news->coordinates }}],
            zoom: 16,
            controls: []
        },
        {
            suppressMapOpenBlock: true
        });

        var myPlacemark = new ymaps.Placemark([{{ $news->coordinates }}], {
            hintContent: '{{ $news->name }}',
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

