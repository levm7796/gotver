<div class="modal modal--preload modal--login-to-account" data-modal="feedback">
    <div class="modal__wrapper">
        <div class="modal__overlay" data-close-modal></div>
        <div class="modal__content">
            <div class="modal__head">
                <p class="modal__title">Написать в поддержку</p>
                <p class="modal__description">Напишите нам и ожидайте ответа в кратчайшие сроки</p>
            </div>
            <div class="modal__form" data-form-validate data-callback="base">
                <form action="#" method="post" data-form="feedback">
                    <div class="custom-input" data-required data-validate-type="text">
                        <label><span class="custom-input__label">Введите имя:</span>
                            <input type="text" name="feed-name" placeholder=" " value="{{ auth()->check() ? auth()->user()->name : '' }}" {{ auth()->check() ? 'disabled' : '' }}>
                        </label>
                    </div>
                    <div class="custom-input" data-required data-validate-type="email">
                        <label><span class="custom-input__label">Введите почту:</span>
                            <input type="email" name="feed-email" placeholder=" " value="{{ auth()->check() ? auth()->user()->email : '' }}" {{ auth()->check() ? 'disabled' : '' }}>
                        </label>
                    </div>
                    <div class="custom-input" data-required data-validate-type="text">
                        <label><span class="custom-input__label">Введите сообшение:</span>
                            <textarea type="text" name="feed-message" placeholder=" "></textarea>
                        </label>
                    </div>
                    <button class="main-btn" type="submit"><span>Отправить</span>
                        <svg width="40" height="40" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#arrow-black"></use>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        <button class="modal__close-btn" type="button" aria-label="Закрыть попап" data-close-modal>
            <svg width="24" height="24" aria-hidden="true">
                <use xlink:href="/img/sprite.svg#close"></use>
            </svg>
        </button>
    </div>
</div>
