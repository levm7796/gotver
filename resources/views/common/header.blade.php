<header class="header" data-header="">
    <div class="container">
        <div class="header__top">
            <div class="logo">
                <a href="/"><img src="/img/svg/logo-header.svg" width="204" height="32" alt="логотип"></a>
                <p class="logo__text">Главный туристический портал Тверской области</p>
            </div>
            <button class="menu-button" type="button" data-burger>
                <span class="menu-button__icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <span class="menu-button__text">Меню</span>
            </button>
            <div class="search">
                <form method="POST" action="/search">
                    @csrf
                    <label>
                        <svg width="24" height="24" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#search"></use>
                        </svg>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Найти место или событие">
                        <button type="submit" style="display: none">submit</button>
                    </label>
                </form>
            </div>
            @include('common.login')
        </div>
    </div>
    @if($page_story)
    <div class="header__bottom">
        <div class="container">
            <div class="menu-user-navigation swiper">
                <div class="swiper-wrapper">
                    @foreach($page_story->content as $key => $story)
                    <a class="user-navigation-item
                    user-navigation-item--{{['red', 'green', 'blue', 'purple'][$key % 4]}}
                    swiper-slide" href="#" data-open-modal="main-slider-{{$key}}">
                        <div class="user-navigation-item__images">
                            @foreach(array_slice($story->items,0 ,3) as $item)
                            <div class="user-navigation-item__picture">
                                <picture>
                                    {{-- <source type="image/webp"
                                        srcset="/img/content/user-navigation/image-01.webp, /img/content/user-navigation/image-01@2x.webp 2x"> --}}
                                    <img src="{{ optional($item)->imgthumb }}"
                                        srcset="{{ optional($item)->imgthumb }}" width="40"
                                        height="40" alt="иконка достопримеча́тельности" loading="eager">
                                </picture>
                            </div>
                            @endforeach
                        </div>
                        <div class="user-navigation-item__text">
                            <p class="user-navigation-item__title">{{ $story->name }}</p>
                            <p class="user-navigation-item__info">+{{ count($story->items) }} историй</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="main-navigation" data-scroll-lock-scrollable>
        <button class="modal__close-btn close" type="button" aria-label="Закрыть попап" onclick="document.querySelector('.menu-button').click()">
            <svg width="24" height="24" aria-hidden="true">
                <use xlink:href="/img/sprite.svg#close"></use>
            </svg>
        </button>
        <div class="main-navigation__search">
            <div class="container">
                <div class="search">
                    <form action="#" method="get">
                        <label>
                            <svg width="24" height="24" aria-hidden="true">
                                <use xlink:href="/img/sprite.svg#search"></use>
                            </svg>
                            <input type="search" name="search" placeholder="Найти место или событие">
                        </label>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="main-navigation__container" data-tabs="parent" data-accordion-media="(max-width:767px)"
                data-single>
                <div class="main-navigation__controls" data-tabs="controls">
                    @foreach($locations as $location)
                    <button class="main-navigation__control" type="button" data-tabs="control">
                        <svg width="5" height="8" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#arrow-nav"></use>
                        </svg>
                        <span onclick="window.location.href='{{$location->myUrl()}}'">
                            {{ $location->name }}
                        </span>
                        <span></span>
                        <svg width="5" height="8" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#arrow-nav"></use>
                        </svg>
                    </button>
                    @endforeach
                </div>
                <div class="main-navigation__wrap">
                    <div class="main-navigation__content" data-tabs="content">
                        @foreach($locations as $location)
                        <div class="main-navigation__element" data-tabs="element">
                            @php
                                $menu_link = optional($location->getContent())['menu_links'];
                                $menu_link = $menu_link ? json_decode($menu_link) : [];
                            @endphp
                            @if(count($location->hubs) > 0)
                            <div class="main-navigation__element-group">
                                @foreach($location->hubs as $hub)
                                {{-- <p class="main-navigation__element-group-title">{{ $obj->name }}</p> --}}
                                <ul class="main-navigation__element-group-list">
                                    <li><a class="main-navigation__element-link" href="{{ $hub->myUrl() }}">{!! str_replace(' ', "&nbsp;", $hub->name) !!}</a></li>
                                </ul>
                                @endforeach
                            </div>
                            @endif
                            @foreach($menu_link as $obj)
                            <div class="main-navigation__element-group">
                                <p class="main-navigation__element-group-title">{{ $obj->name }}</p>
                                <ul class="main-navigation__element-group-list">
                                    @foreach($obj->list as $link)
                                    <li><a class="main-navigation__element-link" href="{{ $link->url }}">{{ $link->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                    <div class="main-navigation__total-container-links">
                        <div class="main-navigation__total-group-links">
                            <p class="main-navigation__total-group-links-title">Направления:</p>
                            <ul class="main-navigation__total-group-links-list">
                                @if(is_array(optional($common)['roads']))
                                    @foreach(optional($common)['roads'] as $road)
                                    <li><a class="main-navigation__total-group-link" href="{{ $road->url }}">{{ $road->name }}</a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="main-navigation__total-group-links">
                            <p class="main-navigation__total-group-links-title">Пользователям:</p>
                            <ul class="main-navigation__total-group-links-list">
                                @if(is_array(optional($common)['users']))
                                    @foreach(optional($common)['users'] as $us)
                                    <li>
                                        <a class="main-navigation__total-group-link" href="{{ $us->url }}">
                                            <svg width="24" height="24" aria-hidden="true">
                                                <use xlink:href="/img/sprite.svg#{{ $us->icon }}"></use>
                                            </svg><span>{{ $us->name }}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-navigation__footer">
            <div class="container">
                <div class="main-navigation__footer-content">
                    @if(!empty($footer['dzen']) || !empty($footer['vk']) || !empty($footer['tg']) || !empty($footer['ok']) )
                    <div class="socials">
                        <p class="socials__text">Мы в соц. сетях:</p>
                        <ul class="socials__list">
                            @if(!empty($footer['dzen']))
                            <li class="socials__item">
                                <a class="socials__link" target="_blank" href="{{ $footer['dzen'] }}">
                                    <svg width="32" height="32" aria-hidden="true">
                                        <use xlink:href="/img/sprite.svg#dzen"></use>
                                    </svg><span class="visually-hidden">Дзен</span></a>
                            </li>
                            @endif
                            @if(!empty($footer['vk']))
                            <li class="socials__item">
                                <a class="socials__link" target="_blank" href="{{ $footer['vk'] }}">
                                    <svg width="32" height="32" aria-hidden="true">
                                        <use xlink:href="/img/sprite.svg#vk"></use>
                                    </svg><span class="visually-hidden">ВК</span></a>
                            </li>
                            @endif
                            @if(!empty($footer['tg']))
                            <li class="socials__item">
                                <a class="socials__link" target="_blank" href="{{ $footer['tg'] }}">
                                    <svg width="32" height="32" aria-hidden="true">
                                        <use xlink:href="/img/sprite.svg#telegram"></use>
                                    </svg><span class="visually-hidden">Телеграм</span></a>
                            </li>
                            @endif
                            @if(!empty($footer['ok']))
                            <li class="socials__item">
                                <a class="socials__link" target="_blank" href="{{ $footer['ok'] }}">
                                    <svg width="32" height="32" aria-hidden="true">
                                        <use xlink:href="/img/sprite.svg#odnoklasniki"></use>
                                    </svg><span class="visually-hidden">Одноклассники</span></a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @endif
                    <div class="call-support">
                        <div class="call-support__text">
                            <p class="call-support__question">Нужна помощь?</p>
                            <p class="call-support__slogan">Написать в поддержку</p>
                        </div><a class="call-support__icon" href="#" data-open-modal="feedback">
                            <svg width="40" height="40" aria-hidden="true">
                                <use xlink:href="/img/sprite.svg#arrow-white"></use>
                            </svg></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<style>
    .main-navigation .close{
        display: none;
    }
    @media (min-width: 1000px) {
        .main-navigation{
            position: fixed;
            top: 0;
            background-color: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            padding: 0;
        }
        .main-navigation .container{
            background-color: rgb(255 255 255);
            padding-top: 50px;
            width: 66%;
            position: absolute;
            float: left;
        }
        .main-navigation .main-navigation__footer{
            z-index: 99;
        }
        .main-navigation .close{
            display: block;
        }
    }

</style>
