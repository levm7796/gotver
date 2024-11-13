<section class="see-also">
    <div class="container">
        <div class="main-title">
            <h2>@if(!empty($settings['titleAlso'])){!! $settings['titleAlso'] !!} @else Смотрите так же @endif</h2>
        </div>
        <div class="articles-slider">
            <div class="articles-slider__container swiper">
                <div class="swiper-wrapper">
                    @if(Auth::check())
                        @php
                            $user = Auth::user();
                            $newsFavorites = optional($user->favorites)['hotels'];
                        @endphp
                    @endif
                    @foreach($news as $new)
                    <div class="news-item item-favorite swiper-slide
                        @if(Auth::check())
                            @php
                                $isFavorite = $newsFavorites ? $newsFavorites->contains($new->id) : false;
                            @endphp
                            {{ $isFavorite ? 'is-favorite' : '' }}
                        @endif
                        ">
                        <div class="news-item__picture">
                            <picture>
                                {{-- <source type="image/webp" srcset="{{ $new->thumbImg }}"> --}}
                                    <img src="{{ $new->thumbImg }}" width="216" height="320" alt="фото новости" loading="lazy">
                            </picture>
                        </div>
                        <div class="news-item__overlay"></div>
                        <div class="news-item__text"><a class="news-item__text-wrapper" href="{{ $new->myUrl() }}">
                                <time datetime="{{ $new->created_at }}">{{  AppHelper::instance()->formatDate($new->created_at) }}</time>
                                <p class="news-item__title">{{ $new->name }}</p>
                                <p class="news-item__description">{{ $new->description }}</p>
                            </a>
                            <div class="news-item__labels">
                                @php
                                    $tag = optional($new->tags)[0];
                                @endphp
                                @if(!is_null($tag))
                                    <p class="label-item" data-tag="{{ $tag->name }}" data-color="blue">{{ $tag->name }}</p>
                                @endif
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
    </div>
</section>
