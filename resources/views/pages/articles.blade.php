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
        $breadcrumbs = [['url' => '/', 'name' => 'Главная'], ['name' => 'Статьи']];
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
                <p class="main-title__description">{{ optional($settings)['seo_text'] }}</p>
            </div>
            <div class="articles-slider">
                <div class="articles-slider__container swiper">
                    <div class="swiper-wrapper">
                        @foreach($news as $new)
                            <div class="news-item item-favorite swiper-slide
                                @if(Auth::check())
                                    @php
                                        $user = Auth::user();
                                        $newsFavorites = optional($user->favorites)['news'];
                                        $isFavorite = $newsFavorites ? $newsFavorites->contains($new->id) : false;
                                    @endphp
                                    {{ $isFavorite ? 'is-favorite' : '' }}
                                @endif
                                ">
                                <div class="news-item__picture">
                                    <picture>
                                        {{-- <source type="image/webp" srcset="{{ $new->thumbImg }}"> --}}
                                            <img src="{{$new->thumbImg }}"
                                            width="216" height="320" alt="фото новости" loading="lazy">
                                    </picture>
                                </div>
                                <div class="news-item__overlay"></div>
                                <div class="news-item__text"><a class="news-item__text-wrapper" href="{{ $new->myUrl() }}">
                                        <time datetime="{{ $new->created_at }}">{{  AppHelper::instance()->formatDate($new->created_at) }}</time>
                                        <p class="news-item__title">{{ $new->name }}</p>
                                        <p class="news-item__description">{{ $new->description }}</p>
                                    </a>
                                    <div class="news-item__labels">
                                        <p class="label-item" data-tag="{{ $new->hub->name }}" data-color="{{ ['red', 'green', 'purple', 'blue'][$new->hub->id % 4] }}">{{ $new->hub->name }}</p>
                                        @if(!empty($new->signature))
                                            <p class="label-item" data-tag="Время чтения: 8 минут" data-color="gray">{{ $new->signature }}</p>
                                        @endif
                                    </div>
                                </div>
                                <button class="action-item" type="button" @if(Auth::check())data-favorite="card" @endif

                                    ><span class="action-item__icon" item-id="{{$new->id}}"
                                        table_name="{{$new->getTable()}}">
                                        <svg width="24" height="24" aria-hidden="true" style="pointer-events: none;">
                                            <use xlink:href="/img/sprite.svg#heart"></use>
                                        </svg></span>
                                </button>
                            </div>
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

            @include('parts.hub-filter-panel_and_grid-container', ['blockTags' => $allTags, 'blockHotels' => $allHotels])
        </div>
    </section>
    <section class="tags-additional">
        <div class="container">
            <div class="main-title">
                <h2>Дополнительные теги</h2>
            </div>
            <div class="tags-additional__wrapper">
                @foreach($tags as $key => $tag)
                <a class="tag-item" href="#"
                    data-tag="{{$tag['name']}}" data-color="{{ ['red', 'green', 'purple', 'blue'][$key % 4] }}">
                    <svg width="16" height="16" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#tag"></use>
                    </svg><span>{{$tag['name']}}</span>
                </a>
                @endforeach
            </div>
            {{-- <a class="main-btn" href="{{ $news->location->myUrl() }}"><span>Все туристические места {{ $news->location->name }}</span>
                <svg width="40" height="40" aria-hidden="true">
                  <use xlink:href="/img/sprite.svg#arrow-black"></use>
                </svg>
              </a> --}}
        </div>
    </section>
    {{--
    <article class="article item-favorite">
        <div class="container">
            <h1>Что посмотреть в Твери зимой</h1>
            <div class="tag-panel swiper" data-showmore="items" data-showmore-media="768,min">
                <div class="tag-panel__wrapper swiper-wrapper" data-showmore-content="1"><a
                        class="tag-item swiper-slide" href="#" data-tag="Кафе Твери" data-color="red">
                        <svg width="16" height="16" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#tag"></use>
                        </svg><span>Кафе Твери</span></a><a class="tag-item swiper-slide" href="#"
                        data-tag="Рестораны Твери" data-color="green">
                        <svg width="16" height="16" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#tag"></use>
                        </svg><span>Рестораны Твери</span></a><a class="tag-item swiper-slide" href="#"
                        data-tag="Отели Твери" data-color="purple">
                        <svg width="16" height="16" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#tag"></use>
                        </svg><span>Отели Твери</span></a><a class="tag-item swiper-slide" href="#"
                        data-tag="Хостелы Твери" data-color="blue">
                        <svg width="16" height="16" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#tag"></use>
                        </svg><span>Хостелы Твери</span></a><a class="tag-item swiper-slide" href="#"
                        data-tag="Экскурсии Твери" data-color="red">
                        <svg width="16" height="16" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#tag"></use>
                        </svg><span>Экскурсии Твери</span></a>
                </div>
                <button class="btn-showmore-round" type="button" hidden
                    data-showmore-button><span></span><span></span></button>
            </div>
            <div class="article__grid">
                <div class="article__content-main">
                    <div class="article__content-aside">
                        <div class="article__chapters">
                            <p class="article__chapters-title">Содержание:</p>
                            <ul class="article__chapters-list">
                                <li><a class="article__chapters-link" href="#part-1">Совершить пешую прогулку по
                                        историческим улицам Твери</a></li>
                                <li><a class="article__chapters-link" href="#part-2">Выбрать активный отдых</a></li>
                                <li><a class="article__chapters-link" href="#part-3">Посещать культурные
                                        достопримечательности</a></li>
                            </ul>
                        </div>
                        <div class="ad-banner"></div>
                    </div>
                    <div class="article__content-article">
                        <figure class="article__cover">
                            <picture>
                                <source type="image/webp"
                                    srcset="/img/content/article/article-01.webp, /img/content/article/article-01@2x.webp 2x">
                                <img src="/img/content/article/article-01.png"
                                    srcset="/img/content/article/article-01@2x.png 2x" width="936" height="540"
                                    alt="фото Твери" loading="eager">
                            </picture>
                        </figure>
                        <div class="article__actions">
                            <button class="action-item" type="button" data-favorite="article"><span
                                    class="action-item__icon">
                                    <svg width="24" height="24" aria-hidden="true">
                                        <use xlink:href="/img/sprite.svg#heart"></use>
                                    </svg></span><span class="action-item__text">Добавить в избранное</span>
                            </button>
                            <button class="action-item" type="button" data-open-modal="tell-about"><span
                                    class="action-item__icon">
                                    <svg width="24" height="24" aria-hidden="true">
                                        <use xlink:href="/img/sprite.svg#share"></use>
                                    </svg></span><span class="action-item__text">Рассказать друзьям</span>
                            </button>
                        </div>
                        <div class="ad-banner"></div>
                        <div class="article__section" id="part-1">
                            <h2>Совершить пешую прогулку по историческим улицам Твери</h2>
                            <p>
                                Зимой на них совершенно иная атмосфера, чем летом. Темнота наступает рано, и в
                                городе включается праздничная иллюминация. Она украшает дома, деревья и даже небо,
                                создавая ощущение приближающегося волшебства.
                                В преддверии Нового года и Рождества на главной пешеходной улице - <a
                                    href="#">Трёхсвятской</a>
                                работают стилизованные киоски. Они стоят всю зиму, и в них вы сможете приобрести сувенирную
                                продукцию, а также горячий ароматный глинтвейн или медовуху. Координаты: 56.855669,
                                35.909822.
                            </p>
                        </div>
                        <figure>
                            <picture>
                                <source type="image/webp"
                                    srcset="/img/content/article/article-02.webp, /img/content/article/article-02@2x.webp 2x">
                                <img src="/img/content/article/article-02.png"
                                    srcset="/img/content/article/article-02@2x.png 2x" width="936" height="624"
                                    alt="фото Твери" loading="lazy">
                            </picture>
                            <figcaption>На Трехсвятской работают стилизованные киоски</figcaption>
                        </figure>
                        <div class="article__section" id="part-2">
                            <h3>Выбрать активный отдых</h3>
                            <p>
                                Не менее прекрасен и бульвар Радищева, который пересекает Трёхсвятскую. Зимой в тёмное время
                                суток он выглядит как сказочный лес. На бульваре обязательно посмотрите памятник известному
                                на всю Россию тверскому шансонье Михаилу Кругу. Можно сказать, что бульвар Радищева даже
                                ассоциируется у людей с именем артиста, хотя монумент появился относительно недавно - в 2007
                                году.
                                А вообще улица эта старинная. Почти каждый дом здесь - памятник архитектуры или объект
                                культурного наследия. Координаты: 56.857076, 35.909462.
                            </p>
                            <p>
                                К Трёхсвятской и бульвару примыкают и другие живописные улицы исторического центра Твери:
                                Андрея Дементьева, Пушкинская, Крылова, Салтыкова-Щедрина, Желябова, Симеоновская.
                                Это отличные места, чтобы полюбоваться красивой старинной архитектурой.
                            </p>
                            <div class="ad-banner"></div>
                            <p>
                                Ещё одна локация для прогулки - улица Советская. Кроме того, что она интересна своей
                                историей,
                                вечером по Советской можно пройти под “звёздным небом”. Это гирлянда в виде навеса, которая
                                протянулась по всей длине улицы.
                            </p>
                            <p>
                                До революции Советская имела название Миллионная и Екатерининская. Была спроектирована по
                                приказу императрицы Екатерины II после разрушительного пожара 1763 года. Сегодня почти
                                каждое здание на улице имеет свою историю. Про улицу Советскую мы много и интересно
                                рассказываем вот тут. Координаты: 56.859552, 35.911663.
                            </p>
                            <p>
                                В самом конце Советской в створе Смоленского переулка можно посмотреть необычное здание -
                                “Рюмку”. Благодаря железобетонному основанию и форме усечённой пирамиды здание и впрямь
                                напоминает рюмку на ножке. Сооружение имеет высоту в 77 метров. На последнем этаже
                                оборудована
                                смотровая площадка “Панорама”. Оттуда вся Тверь видна как на ладони. А рядом памятник
                                архитектуры начала XX века - здание Тверской соборной мечети.
                            </p>
                        </div>
                        <figure>
                            <picture>
                                <source type="image/webp"
                                    srcset="/img/content/article/article-03.webp, /img/content/article/article-03@2x.webp 2x">
                                <img src="/img/content/article/article-03.png"
                                    srcset="/img/content/article/article-03@2x.png 2x" width="936" height="546"
                                    alt="фото Твери" loading="lazy">
                            </picture>
                            <figcaption>На Трехсвятской работают стилизованные киоски</figcaption>
                        </figure>
                        <div class="article__section" id="part-3">
                            <h4>Посещать культурные достопримечательности</h4>
                            <p>
                                Неплохой вариант того, что посмотреть в Твери зимой. Особенно если погода не располагает
                                к длительным прогулкам и пребыванию на улице. Тверь - город с более чем тысячелетней
                                историей.
                                Он сохранил множество уникальных сооружений и предметов искусства, которые обязательно
                                стоит посмотреть.
                            </p>
                        </div>
                        <div class="article__actions">
                            <button class="action-item" type="button" data-favorite="article"><span
                                    class="action-item__icon">
                                    <svg width="24" height="24" aria-hidden="true">
                                        <use xlink:href="/img/sprite.svg#heart"></use>
                                    </svg></span><span class="action-item__text">Добавить в избранное</span>
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
                <div class="article__content-footer">
                    <div id="map"></div>
                    <div class="article__info-panel">
                        <div class="article__author"><span>Автор:</span><a href="#">Валерий Новожилов,</a>
                            <time datetime="2011">8 мая 2024</time>
                        </div>
                        <div class="activity-panel">
                            <div class="activity-panel__item">
                                <svg width="20" height="20" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#eye"></use>
                                </svg><span>1 473</span>
                            </div>
                            <div class="activity-panel__item">
                                <svg width="20" height="20" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#like"></use>
                                </svg><span>215</span>
                            </div>
                            <div class="activity-panel__item">
                                <svg width="20" height="20" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#comment"></use>
                                </svg><span>31</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
    --}}
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
    document.addEventListener('click', function(event) {
        console.log(event.target)
        if (event.target.matches('.action-item__icon')) {
            handleIconClick(event.target);
        }
        function handleIconClick(btn) {
            console.log('Handle icon click:', event.target);
            let block = btn.closest('.news-item');
            let auth = {{ Auth::check() ? 'true':'false' }}
            if (auth) {
                const itemId = btn.getAttribute('item-id');
                const tableName = btn.getAttribute('table_name');
                favorite(tableName,itemId)
            } else {
                modals.open('login-to-account')
            }
        }
    });
    </script>
@endsection
