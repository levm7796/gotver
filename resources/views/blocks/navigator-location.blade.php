<section class="navigator-location">
    <div class="container">
        <div class="main-title">
            <h2>Ваш путеводитель по {{ $lct->putevoditel_po }}</h2>
            <p class="main-title__description">В рамках спецификации современных стандартов, акционеры крупнейших компаний освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы, разумеется, в равной степени предоставлены сами себе.</p>
        </div>
        <div class="navigator-location__slider swiper">
            <div class="swiper-wrapper" >
                @foreach($locations as $key => $location)
                <a class="navigator-location-item {{
                                                        [   'navigator-location-item--green',
                                                            'navigator-location-item--red',
                                                            'navigator-location-item--blue',
                                                            'navigator-location-item--purple',
                                                        ][$key % 4]
                                                    }}
                                                    {{ $location->id == $lct->id ? 'is-active' : ''}}
                        navigator-location-item swiper-slide" href="javascript:void(0)" location-id="{{ $location->id }}">
                    <div class="navigator-location-item__icon">
                        <svg width="24" height="24" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#{{$location->icon}}"></use>
                        </svg>
                    </div>
                    <div class="navigator-location-item__description">
                        <p class="navigator-location-item__title">{{ $location->name }}</p>
                        <p class="navigator-location-item__text">{{ $location->btn_text }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @include('blocks.navigator-location-main-intro')
</section>
