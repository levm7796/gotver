<div class="modal modal--preload modal--user-registration" data-modal="user-registration">
    <div class="modal__wrapper">
        <div class="modal__overlay" data-close-modal></div>
        <div class="modal__content">
            <div class="modal__head">
                <p class="modal__title">Регистрация пользователя</p>
                <p class="modal__description">Зарегистрируйтесь, чтобы получить доступ к расширенному функционалу</p>
            </div>
            <div class="modal__form" data-form-validate data-callback="base">
                <form action="#" method="post" data-form="user-registration">
                    <div class="custom-input" data-required data-validate-type="text">
                        <label><span class="custom-input__label">Введите ваше имя:</span>
                            <input type="text" name="name-registration" placeholder="Иван">
                        </label>
                    </div>
                    <div class="custom-input" data-required data-validate-type="phone">
                        <label><span class="custom-input__label">Введите номер телефона:</span>
                            <input type="tel" name="phone-registration" placeholder="+7 (___) ___-__-__">
                        </label>
                    </div>
                    <div class="custom-input" data-required data-validate-type="text">
                        <label><span class="custom-input__label">Введите пароль:</span>
                            <input type="password" name="password-registration" placeholder=" ">
                        </label>
                    </div>
                    <div class="custom-input" data-required data-validate-type="text">
                        <label><span class="custom-input__label">Введите пароль еще раз:</span>
                            <input type="password" name="repeat-password-registration" placeholder=" ">
                        </label>
                    </div>
                    <button class="main-btn" type="submit"><span>Получить код регистрации</span>
                        <svg width="40" height="40" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#arrow-black"></use>
                        </svg>
                    </button>
                    <div class="custom-toggle custom-toggle--checkbox" data-validate-type="checkbox">
                        <label>
                            <input type="checkbox" name="personal-data-registration" checked><span
                                class="custom-toggle__icon">
                                <svg width="12" height="8" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#check"></use>
                                </svg></span><span class="custom-toggle__label">Нажимая «отправить», я даю согласие на
                                обработку персональных данных</span>
                        </label>
                    </div>
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
