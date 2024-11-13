<div class="modal modal--preload modal--tell-about" data-modal="tell-about">
    <div class="modal__wrapper">
        <div class="modal__overlay" data-close-modal></div>
        <div class="modal__content">
            <div class="modal__head">
                <p class="modal__title">Рассказать друзьям про <span> «‎{{ $name }}»‎</span></p>
                <p class="modal__description">Поделись этой записью с друзьями любым удобным для тебя способом:</p>
            </div>
            <div class="modal-group">
                <div class="modal-group__link-about">
                    <svg class="modal-group__icon-title" width="32" height="32" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#href-about"></use>
                    </svg>
                    <p class="modal-group__link-about-name modal-group__link-about-name--copy" data-target>
                        {{ $url }}
                    </p>
                    <div class="modal-group__link-about-button-wrapper">
                        <button class="modal-group__link-about-button" type="button" data-copy>
                            <svg class="modal-group__icon-action" width="32" height="32" aria-hidden="true">
                                <use xlink:href="/img/sprite.svg#copy-about"></use>
                            </svg>
                        </button><span class="modal-group__link-about-tooltip">Скопировано в буфер</span>
                    </div>
                </div>
                <a class="modal-group__link-about" href="#" id="share-vk" target="_blank">
                    <svg class="modal-group__icon-title" width="32" height="32" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#vk-about"></use>
                    </svg>
                    <p class="modal-group__link-about-name">ВКонтакте</p>
                    <svg class="modal-group__icon-action" width="32" height="32" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#arrow-about"></use>
                    </svg>
                </a>
                <a class="modal-group__link-about" href="#" id="share-tg" target="_blank">
                    <svg class="modal-group__icon-title" width="32" height="32" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#telegram-about"></use>
                    </svg>
                    <p class="modal-group__link-about-name">Телеграм</p>
                    <svg class="modal-group__icon-action" width="32" height="32" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#arrow-about"></use>
                    </svg>
                </a>
                <a class="modal-group__link-about" href="#" id="share-ok" target="_blank">
                    <svg class="modal-group__icon-title" width="32" height="32" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#odnoklasniki-about"></use>
                    </svg>
                    <p class="modal-group__link-about-name">Одноклассники</p>
                    <svg class="modal-group__icon-action" width="32" height="32" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#arrow-about"></use>
                    </svg>
                </a>
            </div>
        </div>
        <button class="modal__close-btn" type="button" aria-label="Закрыть попап" data-close-modal>
            <svg width="24" height="24" aria-hidden="true">
                <use xlink:href="/img/sprite.svg#close"></use>
            </svg>
        </button>
    </div>
</div>
<script>
    function createShareUrl(platform) {
        url = window.location.href
        switch (platform) {
            case 'vk':
                return `https://vk.com/share.php?url=${encodeURIComponent(url)}`;
            case 'tg':
                return `https://t.me/share/url?url=${encodeURIComponent(url)}`;
            case 'ok':
                return `https://ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl=${encodeURIComponent(url)}`;
            default:
                return '#';
        }
    }
    document.getElementById('share-vk').href = createShareUrl('vk');
    document.getElementById('share-tg').href = createShareUrl('tg');
    document.getElementById('share-ok').href = createShareUrl('ok');
</script>
