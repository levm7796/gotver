
<section class="popular-articles">
    <div class="container">
        <div class="main-title">
            <h2>Популярные статьи</h2>
            @if(isset($articleDescription))
            <p class="main-title__description">{!! $articleDescription !!}</p>
            @endif
        </div>
        <a class="main-btn" href="/articles"><span>Посмотреть всё</span>
            <svg width="40" height="40" aria-hidden="true">
                <use xlink:href="/img/sprite.svg#arrow-black"></use>
            </svg>
        </a>
        <div class="popular-articles__slider-container">
            <div class="popular-articles__slider swiper @if(optional($lct->getContent())['autoplay'] == 1) autoplay @endif">
                <div class="swiper-wrapper">
                    @foreach($articles as $article)
                    <div class="news-item item-favorite swiper-slide
                            @if(Auth::check())
                                @php
                                    $user = Auth::user();
                                    $newsFavorites = optional($user->favorites)['news'];
                                    $isFavorite = $newsFavorites ? $newsFavorites->contains($article->id) : false;
                                @endphp
                                {{ $isFavorite ? 'is-favorite' : '' }}
                            @endif
                        ">
                        <div class="news-item__picture">
                            <picture>
                                <source type="image/webp"
                                            srcset="{{$article->thumbImg }}"><img
                                            src="{{ $article->thumbImg }}"
                                            width="216" height="320" alt="фото статьи" loading="lazy">
                            </picture>
                        </div>
                        <div class="news-item__overlay"></div>
                        <div class="news-item__text">
                            <a class="news-item__text-wrapper" href="{{ $article->myUrl() }}">
                            <time datetime="{{ $article->created_at }}">{{  AppHelper::instance()->formatDate($article->created_at) }}</time>
                                <p class="news-item__title">{{ $article->name }}</p>
                                <p class="news-item__description">{{ $article->description }}</p>
                            </a>
                            <div class="news-item__labels">
                                @if(optional($article->tags)[0])
                                <p class="label-item" data-tag="{{ $article->tags[0]->name }}" data-color="{{ ['red', 'green', 'purple', 'blue'][$article->tags[0]->id % 4] }}">{{ $article->tags[0]->name }}</p>
                                @else
                                <p class="label-item" data-tag="{{ $article->hub->name }}" data-color="{{ ['red', 'green', 'purple', 'blue'][$article->hub->id % 4] }}">{{ $article->hub->name }}</p>
                                @endif
                                @if(!empty($article->signature))
                                    <p class="label-item" data-tag="{{ $article->signature }}" data-color="gray">{{ $article->signature }}</p>
                                @endif
                            </div>
                        </div>
                        <button class="action-item" type="button" item-id="{{$article->id}}"
                                        table_name="{{$article->getTable()}}" ><!-- data-favorite="card" -->
                            <span class="action-item__icon">
                                <svg width="24" height="24" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#heart"></use>
                                </svg>
                            </span>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="popular-articles__slider-buttons">
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
