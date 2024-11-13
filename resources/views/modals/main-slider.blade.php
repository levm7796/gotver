<div class="modal modal--preload modal--main-slider" data-modal="main-slider-{{$key}}">
    <div class="modal__wrapper">
        <div class="modal__overlay" data-close-modal></div>
        <div class="modal__content">
            <div class="modal-main-slider swiper">
                <div class="swiper-wrapper">
                    @foreach($story->items as $key => $item)
                    <div class="modal-main-slider__slide swiper-slide" >
                        <div class="modal-main-slider__slide-picture">
                            <picture>
                                {{-- <source type="image/webp" srcset="/img/content/hero-slider/hero-01.webp, /img/content/hero-slider/hero-01@2x.webp 2x"> --}}
                                <img src="{{ optional($item)->img }}" srcset="{{ optional($item)->img }}" width="1068" height="480" alt="виды {{ $item->name }}" loading="lazy">
                            </picture>
                        </div>
                        <div class="modal-main-slider__overlay"></div>
                        <div class="modal-main-slider__info">
                            <div class="modal-main-slider__description">
                                <p class="modal-main-slider__title">{{ $item->name }}</p>
                                <p class="modal-main-slider__text">{{ $item->description }}</p>
                            </div>
                            @if(!empty(optional($item)->btn))
                            <a class="main-btn main-btn--main-slider" href="{{ $item->url }}"><span>{{ $item->btn }}</span> {{-- направления туризма --}}
                                <svg width="40" height="40" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#arrow-white"></use>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="modal-main-slider__pagination swiper-pagination"></div>
            </div>
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
            <button class="modal__close-link" type="button" aria-label="Закрыть попап" data-close-modal>Вернуться на
                сайт</button>
        </div>
        <button class="modal__close-btn" type="button" aria-label="Закрыть попап" data-close-modal>
            <svg width="24" height="24" aria-hidden="true">
                <use xlink:href="/img/sprite.svg#close"></use>
            </svg>
        </button>
    </div>
</div>
