<div class="modal modal--preload modal--card-slider" data-modal="card-slider">
    <div class="modal__wrapper">
        <div class="modal__overlay" data-close-modal></div>
        <div class="modal__content">
        <div class="modal-card-slider">
            <div class="modal-card-slider__main swiper mySwiper2">
            <div class="swiper-wrapper">
                @if(isset($imgs))
                    @foreach($imgs as $img)
                        <div class="modal-card-slider__main-slide swiper-slide">
                        <picture>
                            <source type="image/webp"><img src="{{$img['img']}}" width="456" height="278" alt="виды отеля" loading="lazy">
                        </picture>
                        </div>
                    @endforeach
                @endif
{{--                <div class="modal-card-slider__main-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-02.webp, /img/content/cards/card-02@2x.webp 2x"><img src="/img/content/cards/card-02.png" srcset="/img/content/cards/card-02@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__main-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-03.webp, /img/content/cards/card-03@2x.webp 2x"><img src="/img/content/cards/card-03.png" srcset="/img/content/cards/card-03@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__main-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-01.webp, /img/content/cards/card-01@2x.webp 2x"><img src="/img/content/cards/card-01.png" srcset="/img/content/cards/card-01@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__main-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-02.webp, /img/content/cards/card-02@2x.webp 2x"><img src="/img/content/cards/card-02.png" srcset="/img/content/cards/card-02@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__main-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-03.webp, /img/content/cards/card-03@2x.webp 2x"><img src="/img/content/cards/card-03.png" srcset="/img/content/cards/card-03@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__main-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-01.webp, /img/content/cards/card-01@2x.webp 2x"><img src="/img/content/cards/card-01.png" srcset="/img/content/cards/card-01@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__main-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-02.webp, /img/content/cards/card-02@2x.webp 2x"><img src="/img/content/cards/card-02.png" srcset="/img/content/cards/card-02@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__main-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-03.webp, /img/content/cards/card-03@2x.webp 2x"><img src="/img/content/cards/card-03.png" srcset="/img/content/cards/card-03@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__main-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-01.webp, /img/content/cards/card-01@2x.webp 2x"><img src="/img/content/cards/card-01.png" srcset="/img/content/cards/card-01@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__main-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-02.webp, /img/content/cards/card-02@2x.webp 2x"><img src="/img/content/cards/card-02.png" srcset="/img/content/cards/card-02@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
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
            </div>
            <div class="modal-card-slider__preview swiper mySwiper" data-thumbsSlider="">
            <div class="swiper-wrapper">
                @if(isset($imgs))
                    @foreach($imgs as $img)
                        <div class="modal-card-slider__preview-slide swiper-slide">
                            <picture>
                                <source type="image/webp"><img src="{{$img['thumb']}}" width="456" height="278" alt="виды отеля" loading="lazy">
                            </picture>
                        </div>
                    @endforeach
                @endif
{{--                <div class="modal-card-slider__preview-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-02.webp, /img/content/cards/card-02@2x.webp 2x"><img src="/img/content/cards/card-02.png" srcset="/img/content/cards/card-02@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__preview-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-03.webp, /img/content/cards/card-03@2x.webp 2x"><img src="/img/content/cards/card-03.png" srcset="/img/content/cards/card-03@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__preview-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-01.webp, /img/content/cards/card-01@2x.webp 2x"><img src="/img/content/cards/card-01.png" srcset="/img/content/cards/card-01@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__preview-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-02.webp, /img/content/cards/card-02@2x.webp 2x"><img src="/img/content/cards/card-02.png" srcset="/img/content/cards/card-02@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__preview-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-03.webp, /img/content/cards/card-03@2x.webp 2x"><img src="/img/content/cards/card-03.png" srcset="/img/content/cards/card-03@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__preview-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-01.webp, /img/content/cards/card-01@2x.webp 2x"><img src="/img/content/cards/card-01.png" srcset="/img/content/cards/card-01@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__preview-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-02.webp, /img/content/cards/card-02@2x.webp 2x"><img src="/img/content/cards/card-02.png" srcset="/img/content/cards/card-02@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__preview-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-03.webp, /img/content/cards/card-03@2x.webp 2x"><img src="/img/content/cards/card-03.png" srcset="/img/content/cards/card-03@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__preview-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-01.webp, /img/content/cards/card-01@2x.webp 2x"><img src="/img/content/cards/card-01.png" srcset="/img/content/cards/card-01@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
{{--                <div class="modal-card-slider__preview-slide swiper-slide">--}}
{{--                <picture>--}}
{{--                    <source type="image/webp" srcset="/img/content/cards/card-02.webp, /img/content/cards/card-02@2x.webp 2x"><img src="/img/content/cards/card-02.png" srcset="/img/content/cards/card-02@2x.png 2x" width="456" height="278" alt="виды отеля" loading="lazy">--}}
{{--                </picture>--}}
{{--                </div>--}}
            </div>
            </div>
        </div>
        </div>
        <button class="modal__close-btn" type="button" aria-label="Закрыть попап" data-close-modal>
        <svg width="24" height="24" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#close"></use>
        </svg>
        </button>
    </div>
    </div>


