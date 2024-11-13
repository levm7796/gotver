<footer class="footer">
    <div class="container">
        <div class="footer__wrap">
            <div class="call-support">
                <div class="call-support__text">
                    <p class="call-support__question">Нужна помощь?</p>
                    <p class="call-support__slogan">Написать в поддержку</p>
                </div>
                <a class="call-support__icon" href="#" data-open-modal="feedback">
                    <svg width="40" height="40" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#arrow-white"></use>
                    </svg>
                </a>
            </div>
            <div class="logo"><img src="/img/svg/logo-footer.svg" width="204" height="32" loading="lazy"
                    alt="логотип">
                <p class="logo__text">Главный туристический портал Тверской области</p>
            </div>
            <div class="footer__navigation-group">
                <p class="footer__navigation-group-title">Локации</p>
                <ul class="footer__navigation-group-list">
                    @foreach($locations as $location)
                        <li class="footer__navigation-group-item menu-item" data-target="menu{{ $location->id }}">
                            @if(count($location->hubs) > 0)
                            <span class="icon">▶</span>
                            @endif
                            <a class="footer__navigation-group-link" href="{{ $location->myUrl() }}">
                                {{ $location->name }}
                            </a>
                        </li>
                        <div class="menu-content" id="menu{{ $location->id }}">
                            @foreach($location->hubs as $hub)
                            <li class="footer__navigation-group-item">
                                <a class="footer__navigation-group-link" href="{{ $hub->myUrl() }}">
                                    {!! str_replace(' ', "&nbsp;", $hub->name) !!}
                                </a>
                            </li>
                            @endforeach
                        </div>
                    @endforeach
                </ul>
            </div>
            <style>
                .menu-content {
                    max-height: 0;
                    overflow: hidden;
                    transition: max-height 0.3s ease;
                    padding: 0 10px;
                }

            </style>
            <script>
                const menuItems = document.querySelectorAll('.menu-item');

                menuItems.forEach(item => {
                    item.addEventListener('click', function() {
                        const target = this.getAttribute('data-target');
                        const menu = document.getElementById(target);
                        const icon = this.querySelector('.icon');

                        document.querySelectorAll('.menu-content').forEach(content => {
                            if (content !== menu) {
                                content.style.maxHeight = null;
                                const otherIcon = content.previousElementSibling.querySelector('.icon');
                                if(otherIcon)
                                    otherIcon.textContent = '▶';
                            }
                        });

                        if (menu.style.maxHeight) {
                            menu.style.maxHeight = null;
                            if(icon)
                                icon.textContent = '▶';
                        } else {
                            menu.style.maxHeight = menu.scrollHeight + "px";
                            if(icon)
                                icon.textContent = '▼';
                        }
                    });
                });
            </script>
            <div class="footer__navigation-group">
                <p class="footer__navigation-group-title">Пользователям</p>
                <ul class="footer__navigation-group-list">
                    @php
                        $fls = optional($common)['footer_links'];
                        $fls = $fls ? $fls : [];
                    @endphp
                    @foreach($fls as $fl)
                    <li class="footer__navigation-group-item">
                        <a class="footer__navigation-group-link"
                            href="{{ $fl->url }}">{{ $fl->name }}</a>
                    </li>
                    @endforeach
                    </ul>
            </div>
            @if(!empty($common['dzen']) || !empty($common['vk']) || !empty($common['tg']) || !empty($common['ok']) )
            <div class="socials">
                <p class="socials__text">Мы в соц. сетях:</p>
                <ul class="socials__list">
                    @if(!empty($common['dzen']))
                    <li class="socials__item">
                        <a class="socials__link" target="_blank" href="{{ $common['dzen'] }}">
                            <svg width="32" height="32" aria-hidden="true">
                                <use xlink:href="/img/sprite.svg#dzen"></use>
                            </svg><span class="visually-hidden">Дзен</span></a>
                    </li>
                    @endif
                    @if(!empty($common['vk']))
                    <li class="socials__item">
                        <a class="socials__link" target="_blank" href="{{ $common['vk'] }}">
                            <svg width="32" height="32" aria-hidden="true">
                                <use xlink:href="/img/sprite.svg#vk"></use>
                            </svg><span class="visually-hidden">ВК</span></a>
                    </li>
                    @endif
                    @if(!empty($common['tg']))
                    <li class="socials__item">
                        <a class="socials__link" target="_blank" href="{{ $common['tg'] }}">
                            <svg width="32" height="32" aria-hidden="true">
                                <use xlink:href="/img/sprite.svg#telegram"></use>
                            </svg><span class="visually-hidden">Телеграм</span></a>
                    </li>
                    @endif
                    @if(!empty($common['ok']))
                    <li class="socials__item">
                        <a class="socials__link" target="_blank" href="{{ $common['ok'] }}">
                            <svg width="32" height="32" aria-hidden="true">
                                <use xlink:href="/img/sprite.svg#odnoklasniki"></use>
                            </svg><span class="visually-hidden">Одноклассники</span></a>
                    </li>
                    @endif
                </ul>
            </div>
            @endif
            <div class="footer__bottom-group">
                <p class="footer__copyright">© 2022 — 2024 «GoTver». Все права защищены.</p>
                <div class="footer__policy-group">
                    <a class="footer__policy-link" href="{{ route('tac') }}">Правила пользования платформой</a>
                    <a class="footer__policy-link" href="{{ route('tos') }}">Политика конфиденциальности</a>
                </div>
                    <a class="footer__developer-link" href="https://ruso.ru/"><span>Сделано в</span>
                        <svg width="52" height="11" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#ruso"></use>
                        </svg>
                    </a>
            </div>
        </div>
    </div>
</footer>
