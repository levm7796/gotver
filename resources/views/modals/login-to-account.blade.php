<div class="modal modal--preload modal--login-to-account" data-modal="login-to-account">
    <div class="modal__wrapper">
        <div class="modal__overlay" data-close-modal></div>
        <div class="modal__content">
            <div class="modal__head">
                <p class="modal__title">Войти в аккаунт</p>
                <p class="modal__description">Зарегистрируйтесь, чтобы получить доступ к расширенному функционалу</p>
            </div>
            <div class="modal__form" data-form-validate data-callback="base">
                <form action="#" method="post" data-form="login-to-account">
                    <div class="custom-input" data-required data-validate-type="phone">
                        <label><span class="custom-input__label">Введите номер телефона:</span>
                            <input type="tel" name="phone-login" placeholder="+7 (___) ___-__-__">
                        </label>
                    </div>
                    <div class="custom-input" data-required data-validate-type="text">
                        <label><span class="custom-input__label">Введите пароль:</span>
                            <input type="password" name="password-login" placeholder=" ">
                        </label>
                    </div>
                    <button class="main-btn" type="submit"><span>Войти</span>
                        <svg width="40" height="40" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#arrow-black"></use>
                        </svg>
                    </button>
                    <p class="modal__text">Еще нет аккаунта? <a class="modal__link" href="#"
                            data-open-modal="user-registration">Зарегистрироваться</a></p>
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
