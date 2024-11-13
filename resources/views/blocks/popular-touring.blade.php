<section class="popular-touring">
    <div class="container">
        <div class="main-title">
            <h2>Популярные <br> направления туризма</h2>
            @if(isset($touringDescription))
            <p class="main-title__description">{!! $touringDescription !!}</p>
            @endif
        </div>
        <a class="main-btn" href="{{ $current_location->myUrl() }}"><span>Посмотреть всё</span>
            <svg width="40" height="40" aria-hidden="true">
                <use xlink:href="/img/sprite.svg#arrow-black"></use>
            </svg>
        </a>
        <div class="popular-touring__slider-container">
            <div class="popular-touring__slider swiper">
                <div class="swiper-wrapper">
                    @foreach($main_hubs as $hub)
                    <a class="popular-touring-item swiper-slide" href="{{ $hub->myUrl() }}">
                        <div class="popular-touring-item__picture">
                            <picture>
                                {{-- <source type="image/webp"
                                    srcset="/img/content/popular-touring/tour-01.webp, img/content/popular-touring/tour-01@2x.webp 2x">--}}
                                <img src="{{ $hub->img() }}" width="216"
                                    height="320" alt="фото туризма" loading="lazy">
                            </picture>
                        </div>
                        <div class="popular-touring-item__overlay"></div>
                        <p class="popular-touring-item__text">{{ $hub->name }}</p>
                    </a>
                    @endforeach

                </div>
            </div>
            <div class="popular-touring__slider-buttons">
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
