@extends('layout')

@section('title')Go-Tver.ru. Что посмотреть в Твери зимой@endsection
@section('description')GoTver — Ваш путеводитель по Тверской области@endsection

@section('head-end')
<script src="https://api-maps.yandex.ru/2.1/?apikey=39d99a70-dcc3-427d-9e95-c1e01263fb84&amp;lang=ru_RU"></script>
@endsection

@section('body-end')
@endsection

@section('content')
    @php
    $breadcrumbs = [
        ['url' => '#', 'name' => 'Главная'],
        ['url' => '#', 'name' => 'Тверь'],
        ['url' => '#', 'name' => 'Что посмотреть'],
        ['name' => 'Что посмотреть в Твери зимой'],
    ];
    @endphp
@include('blocks.bread-crumbs')
<article class="article item-favorite">
    <div class="container">
      <h1>Что посмотреть в Твери зимой</h1>
      <div class="tag-panel swiper" data-showmore="items" data-showmore-media="768,min">
        <div class="tag-panel__wrapper swiper-wrapper" data-showmore-content="1"><a class="tag-item swiper-slide" href="#" data-tag="Кафе Твери" data-color="red">
            <svg width="16" height="16" aria-hidden="true">
              <use xlink:href="/img/sprite.svg#tag"></use>
            </svg><span>Кафе Твери</span></a><a class="tag-item swiper-slide" href="#" data-tag="Рестораны Твери" data-color="green">
            <svg width="16" height="16" aria-hidden="true">
              <use xlink:href="/img/sprite.svg#tag"></use>
            </svg><span>Рестораны Твери</span></a><a class="tag-item swiper-slide" href="#" data-tag="Отели Твери" data-color="purple">
            <svg width="16" height="16" aria-hidden="true">
              <use xlink:href="/img/sprite.svg#tag"></use>
            </svg><span>Отели Твери</span></a><a class="tag-item swiper-slide" href="#" data-tag="Хостелы Твери" data-color="blue">
            <svg width="16" height="16" aria-hidden="true">
              <use xlink:href="/img/sprite.svg#tag"></use>
            </svg><span>Хостелы Твери</span></a><a class="tag-item swiper-slide" href="#" data-tag="Экскурсии Твери" data-color="red">
            <svg width="16" height="16" aria-hidden="true">
              <use xlink:href="/img/sprite.svg#tag"></use>
            </svg><span>Экскурсии Твери</span></a>
        </div>
        <button class="btn-showmore-round" type="button" hidden data-showmore-button><span></span><span></span></button>
      </div>
      <div class="article__grid">
        <div class="article__content-main">
          <div class="article__content-aside">
            <div class="article__chapters">
              <p class="article__chapters-title">Содержание:</p>
              <ul class="article__chapters-list">
                <li><a class="article__chapters-link" href="#part-1">Совершить пешую прогулку по историческим улицам Твери</a></li>
                <li><a class="article__chapters-link" href="#part-2">Выбрать активный отдых</a></li>
                <li><a class="article__chapters-link" href="#part-3">Посещать культурные достопримечательности</a></li>
              </ul>
            </div>
            <div class="ad-banner"></div>
          </div>
          <div class="article__content-article">
            <figure class="article__cover">
              <picture>
                <source type="image/webp" srcset="/img/content/article/article-01.webp, /img/content/article/article-01@2x.webp 2x"><img src="/img/content/article/article-01.png" srcset="/img/content/article/article-01@2x.png 2x" width="936" height="540" alt="фото Твери" loading="eager">
              </picture>
            </figure>
            <div class="article__actions">
              <button class="action-item" type="button" data-favorite="article"><span class="action-item__icon">
                  <svg width="24" height="24" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#heart"></use>
                  </svg></span><span class="action-item__text">Добавить в избранное</span>
              </button>
              <button class="action-item" type="button" data-open-modal="tell-about"><span class="action-item__icon">
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
                В преддверии Нового года и Рождества на главной пешеходной улице - <a href="#">Трёхсвятской</a>
                работают стилизованные киоски. Они стоят всю зиму, и в них вы сможете приобрести сувенирную
                продукцию, а также горячий ароматный глинтвейн или медовуху. Координаты: 56.855669, 35.909822.
              </p>
            </div>
            <figure>
              <picture>
                <source type="image/webp" srcset="/img/content/article/article-02.webp, /img/content/article/article-02@2x.webp 2x"><img src="/img/content/article/article-02.png" srcset="/img/content/article/article-02@2x.png 2x" width="936" height="624" alt="фото Твери" loading="lazy">
              </picture>
              <figcaption>На Трехсвятской работают стилизованные киоски</figcaption>
            </figure>
            <div class="article__section" id="part-2">
              <h3>Выбрать активный отдых</h3>
              <p>
                Не менее прекрасен и бульвар Радищева, который пересекает Трёхсвятскую. Зимой в тёмное время
                суток он выглядит как сказочный лес. На бульваре обязательно посмотрите памятник известному
                на всю Россию тверскому шансонье Михаилу Кругу. Можно сказать, что бульвар Радищева даже
                ассоциируется у людей с именем артиста, хотя монумент появился относительно недавно - в 2007 году.
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
                Ещё одна локация для прогулки - улица Советская. Кроме того, что она интересна своей историей,
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
                напоминает рюмку на ножке. Сооружение имеет высоту в 77 метров. На последнем этаже оборудована
                смотровая площадка “Панорама”. Оттуда вся Тверь видна как на ладони. А рядом памятник
                архитектуры начала XX века - здание Тверской соборной мечети.
              </p>
            </div>
            <figure>
              <picture>
                <source type="image/webp" srcset="/img/content/article/article-03.webp, /img/content/article/article-03@2x.webp 2x"><img src="/img/content/article/article-03.png" srcset="/img/content/article/article-03@2x.png 2x" width="936" height="546" alt="фото Твери" loading="lazy">
              </picture>
              <figcaption>На Трехсвятской работают стилизованные киоски</figcaption>
            </figure>
            <div class="article__section" id="part-3">
              <h4>Посещать культурные достопримечательности</h4>
              <p>
                Неплохой вариант того, что посмотреть в Твери зимой. Особенно если погода не располагает
                к длительным прогулкам и пребыванию на улице. Тверь - город с более чем тысячелетней историей.
                Он сохранил множество уникальных сооружений и предметов искусства, которые обязательно
                стоит посмотреть.
              </p>
            </div>
            <div class="article__actions">
              <button class="action-item" type="button" data-favorite="article"><span class="action-item__icon">
                  <svg width="24" height="24" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#heart"></use>
                  </svg></span><span class="action-item__text">Добавить в избранное</span>
              </button>
              <button class="action-item" type="button" data-open-modal="tell-about"><span class="action-item__icon">
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
  <section class="tags-additional">
    <div class="container">
      <div class="main-title">
        <h2>Дополнительные теги</h2>
      </div>
      <div class="tags-additional__wrapper"><a class="tag-item" href="#" data-tag="Достопримечательности Ржева" data-color="red">
          <svg width="16" height="16" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#tag"></use>
          </svg><span>Достопримечательности Ржева</span></a><a class="tag-item" href="#" data-tag="Кафе Ржева" data-color="purple">
          <svg width="16" height="16" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#tag"></use>
          </svg><span>Кафе Ржева</span></a><a class="tag-item" href="#" data-tag="Маршруты Ржева" data-color="green">
          <svg width="16" height="16" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#tag"></use>
          </svg><span>Маршруты Ржева</span></a><a class="tag-item" href="#" data-tag="Кафе Ржева" data-color="purple">
          <svg width="16" height="16" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#tag"></use>
          </svg><span>Кафе Ржева</span></a><a class="tag-item" href="#" data-tag="Достопримечательности Ржева" data-color="red">
          <svg width="16" height="16" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#tag"></use>
          </svg><span>Достопримечательности Ржева</span></a><a class="tag-item" href="#" data-tag="Маршруты Ржева" data-color="green">
          <svg width="16" height="16" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#tag"></use>
          </svg><span>Маршруты Ржева</span></a><a class="tag-item" href="#" data-tag="Кафе Ржева" data-color="purple">
          <svg width="16" height="16" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#tag"></use>
          </svg><span>Кафе Ржева</span></a><a class="tag-item" href="#" data-tag="Достопримечательности Ржева" data-color="red">
          <svg width="16" height="16" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#tag"></use>
          </svg><span>Достопримечательности Ржева</span></a>
        <a class="main-btn" href="#"><span>Все туристические места Твери</span>
          <svg width="40" height="40" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#arrow-black"></use>
          </svg>
        </a>
      </div>
    </div>
  </section>
  <section class="see-also">
    <div class="container">
      <div class="main-title">
        <h2>Смотрите так же</h2>
      </div>
      <div class="articles-slider">
        <div class="articles-slider__container swiper">
          <div class="swiper-wrapper">
            <div class="news-item item-favorite swiper-slide">
              <div class="news-item__picture">
                <picture>
                  <source type="image/webp" srcset="/img/content/news/news-01.webp, /img/content/news/news-01@2x.webp 2x"><img src="/img/content/news/news-01.png" srcset="/img/content/news/news-01@2x.png 2x" width="216" height="320" alt="фото новости" loading="lazy">
                </picture>
              </div>
              <div class="news-item__overlay"></div>
              <div class="news-item__text"><a class="news-item__text-wrapper" href="#">
                  <time datetime="2024-05-21">21 мая 2024</time>
                  <p class="news-item__title">Что посмотреть в Твери зимой</p>
                  <p class="news-item__description">Господа, убеждённость некоторых оппонентов требует определения и уточнения форм воздействия. Каждый из нас понимает очевидную вещь: консультация с широким активом воздействия.</p></a>
                <div class="news-item__labels">
                  <p class="label-item" data-tag="Что посмотреть" data-color="blue">Что посмотреть</p>
                  <p class="label-item" data-tag="Время чтения: 8 минут" data-color="gray">Время чтения: 8 минут</p>
                </div>
              </div>
              <button class="action-item" type="button" data-favorite="card"><span class="action-item__icon">
                  <svg width="24" height="24" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#heart"></use>
                  </svg></span>
              </button>
            </div>
            <div class="news-item item-favorite swiper-slide">
              <div class="news-item__picture">
                <picture>
                  <source type="image/webp" srcset="/img/content/news/news-02.webp, /img/content/news/news-02@2x.webp 2x"><img src="/img/content/news/news-02.png" srcset="/img/content/news/news-02@2x.png 2x" width="216" height="320" alt="фото новости" loading="lazy">
                </picture>
              </div>
              <div class="news-item__overlay"></div>
              <div class="news-item__text"><a class="news-item__text-wrapper" href="#">
                  <time datetime="2024-05-21">21 мая 2024</time>
                  <p class="news-item__title">Куда сходить с девушкой в Твери</p>
                  <p class="news-item__description">В Твери более 50 достопримечательностей и большое количество развлекательных мест на любой вкус. Здесь есть старинные улицы, здания, усадьбы, дворцы, театры, монастыри и храмы. Кроме того, в городе и окрестностях полно красивых и притягательных мест для посещения. В этой статье предлагаем вам краткий путеводитель по самым романтическим локациям Твери для свидания вдвоём.</p></a>
                <div class="news-item__labels">
                  <p class="label-item" data-tag="Чем заняться" data-color="red">Чем заняться</p>
                  <p class="label-item" data-tag="Время чтения: 8 минут" data-color="gray">Время чтения: 8 минут</p>
                </div>
              </div>
              <button class="action-item" type="button" data-favorite="card"><span class="action-item__icon">
                  <svg width="24" height="24" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#heart"></use>
                  </svg></span>
              </button>
            </div>
            <div class="news-item item-favorite swiper-slide">
              <div class="news-item__picture">
                <picture>
                  <source type="image/webp" srcset="/img/content/news/news-01.webp, /img/content/news/news-01@2x.webp 2x"><img src="/img/content/news/news-01.png" srcset="/img/content/news/news-01@2x.png 2x" width="216" height="320" alt="фото новости" loading="lazy">
                </picture>
              </div>
              <div class="news-item__overlay"></div>
              <div class="news-item__text"><a class="news-item__text-wrapper" href="#">
                  <time datetime="2024-05-21">21 мая 2024</time>
                  <p class="news-item__title">Что посмотреть в Твери с детьми</p>
                  <p class="news-item__description">В Твери более 50 достопримечательностей и большое количество развлекательных мест на любой вкус. Здесь есть старинные улицы, здания, усадьбы, дворцы, театры, монастыри и храмы. Кроме того, в городе и окрестностях полно красивых и притягательных мест для посещения. В этой статье предлагаем вам краткий путеводитель по самым романтическим локациям Твери для свидания вдвоём.</p></a>
                <div class="news-item__labels">
                  <p class="label-item" data-tag="Что посмотреть" data-color="blue">Что посмотреть</p>
                  <p class="label-item" data-tag="Время чтения: 8 минут" data-color="gray">Время чтения: 8 минут</p>
                </div>
              </div>
              <button class="action-item" type="button" data-favorite="card"><span class="action-item__icon">
                  <svg width="24" height="24" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#heart"></use>
                  </svg></span>
              </button>
            </div>
            <div class="news-item item-favorite swiper-slide">
              <div class="news-item__picture">
                <picture>
                  <source type="image/webp" srcset="/img/content/news/news-01.webp, /img/content/news/news-01@2x.webp 2x"><img src="/img/content/news/news-01.png" srcset="/img/content/news/news-01@2x.png 2x" width="216" height="320" alt="фото новости" loading="lazy">
                </picture>
              </div>
              <div class="news-item__overlay"></div>
              <div class="news-item__text"><a class="news-item__text-wrapper" href="#">
                  <time datetime="2024-05-21">21 мая 2024</time>
                  <p class="news-item__title">Что посмотреть в Твери зимой</p>
                  <p class="news-item__description">Господа, убеждённость некоторых оппонентов требует определения и уточнения форм воздействия. Каждый из нас понимает очевидную вещь: консультация с широким активом воздействия.</p></a>
                <div class="news-item__labels">
                  <p class="label-item" data-tag="Что посмотреть" data-color="blue">Что посмотреть</p>
                  <p class="label-item" data-tag="Время чтения: 8 минут" data-color="gray">Время чтения: 8 минут</p>
                </div>
              </div>
              <button class="action-item" type="button" data-favorite="card"><span class="action-item__icon">
                  <svg width="24" height="24" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#heart"></use>
                  </svg></span>
              </button>
            </div>
            <div class="news-item item-favorite swiper-slide">
              <div class="news-item__picture">
                <picture>
                  <source type="image/webp" srcset="/img/content/news/news-02.webp, /img/content/news/news-02@2x.webp 2x"><img src="/img/content/news/news-02.png" srcset="/img/content/news/news-02@2x.png 2x" width="216" height="320" alt="фото новости" loading="lazy">
                </picture>
              </div>
              <div class="news-item__overlay"></div>
              <div class="news-item__text"><a class="news-item__text-wrapper" href="#">
                  <time datetime="2024-05-21">21 мая 2024</time>
                  <p class="news-item__title">Куда сходить с девушкой в Твери</p>
                  <p class="news-item__description">В Твери более 50 достопримечательностей и большое количество развлекательных мест на любой вкус. Здесь есть старинные улицы, здания, усадьбы, дворцы, театры, монастыри и храмы. Кроме того, в городе и окрестностях полно красивых и притягательных мест для посещения. В этой статье предлагаем вам краткий путеводитель по самым романтическим локациям Твери для свидания вдвоём.</p></a>
                <div class="news-item__labels">
                  <p class="label-item" data-tag="Чем заняться" data-color="red">Чем заняться</p>
                  <p class="label-item" data-tag="Время чтения: 8 минут" data-color="gray">Время чтения: 8 минут</p>
                </div>
              </div>
              <button class="action-item" type="button" data-favorite="card"><span class="action-item__icon">
                  <svg width="24" height="24" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#heart"></use>
                  </svg></span>
              </button>
            </div>
            <div class="news-item item-favorite swiper-slide">
              <div class="news-item__picture">
                <picture>
                  <source type="image/webp" srcset="/img/content/news/news-01.webp, /img/content/news/news-01@2x.webp 2x"><img src="/img/content/news/news-01.png" srcset="/img/content/news/news-01@2x.png 2x" width="216" height="320" alt="фото новости" loading="lazy">
                </picture>
              </div>
              <div class="news-item__overlay"></div>
              <div class="news-item__text"><a class="news-item__text-wrapper" href="#">
                  <time datetime="2024-05-21">21 мая 2024</time>
                  <p class="news-item__title">Что посмотреть в Твери с детьми</p>
                  <p class="news-item__description">В Твери более 50 достопримечательностей и большое количество развлекательных мест на любой вкус. Здесь есть старинные улицы, здания, усадьбы, дворцы, театры, монастыри и храмы. Кроме того, в городе и окрестностях полно красивых и притягательных мест для посещения. В этой статье предлагаем вам краткий путеводитель по самым романтическим локациям Твери для свидания вдвоём.</p></a>
                <div class="news-item__labels">
                  <p class="label-item" data-tag="Что посмотреть" data-color="blue">Что посмотреть</p>
                  <p class="label-item" data-tag="Время чтения: 8 минут" data-color="gray">Время чтения: 8 минут</p>
                </div>
              </div>
              <button class="action-item" type="button" data-favorite="card"><span class="action-item__icon">
                  <svg width="24" height="24" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#heart"></use>
                  </svg></span>
              </button>
            </div>
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
    </div>
  </section>

@endsection
