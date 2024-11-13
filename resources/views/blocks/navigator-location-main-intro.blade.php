<div class="main-intro">
    <div class="main-intro__pictures swiper">
        <div class="swiper-wrapper">
            @foreach($lct->images() as $img)
            <div class="main-intro__picture swiper-slide">
                <picture>
                    {{-- <source type="/image/webp"
                        srcset="/img/content/hero-slider/hero-01.webp, /img/content/hero-slider/hero-01@2x.webp 2x"> --}}
                    <img src="{{ $img }}"
                        srcset="{{ $img }}" width="1068" height="480"
                        alt="виды города" loading="eager">
                </picture>
            </div>
            @endforeach
        </div>
        <div class="container">
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="main-intro__info">
        <div class="container">
            <div class="main-intro__info-wrapper">
                <div class="main-intro__head">
                    <h1 class="main-intro__title">{{ $lct->name }}</h1>
                    <p class="main-intro__subtitle">— это</p>
                </div>
                <div class="main-intro__text">
                    <p class="main-intro__description">{{ $lct->seo_text }}</p>
                    <a class="main-intro__link"
                        href="{{ $lct->myUrl() }}" >
                        <span>Подробнее о {{ $lct->name }}</span>
                        <svg width="9" height="10" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#arrow-total"></use>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="categories-links swiper">
                <div class="swiper-wrapper" hub style="margin-bottom: 25px;">
                    @foreach($lct->selectedHubs() as $hub)
                    <a class="main-btn main-btn--category swiper-slide" href="{{ $hub->myUrl() }}" style="margin-right: 24px;"><span>{{ $hub->name }}</span>
                        <svg width="40" height="40" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#{{ $hub->icon }}"></use>
                        </svg>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
