<div class="modal modal--preload modal--sms-code" data-modal="sms-code">
    <div class="modal__wrapper">
        <div class="modal__overlay" data-close-modal></div>
        <div class="modal__content">
            <div class="modal__head">
                <p class="modal__title">Введите код из SMS</p>
                <p class="modal__description">Зарегистрируйтесь, чтобы получить доступ к расширенному функционалу</p>
            </div>
            <div class="modal__form" data-form-validate data-callback="base">
                <form action="#" method="post" data-form="sms-code">
                    <div class="modal__group-numeric">
                        <div class="custom-input custom-input--numeric" data-required data-validate-type="matrix"
                            data-matrix-limitation="digit" data-matrix="_">
                            <label>
                                <input type="text" name="code-sms-1" inputmode="numeric" placeholder="_">
                            </label>
                        </div>
                        <div class="custom-input custom-input--numeric" data-required data-validate-type="matrix"
                            data-matrix-limitation="digit" data-matrix="_">
                            <label>
                                <input type="text" name="code-sms-2" inputmode="numeric" placeholder="_">
                            </label>
                        </div>
                        <div class="custom-input custom-input--numeric" data-required data-validate-type="matrix"
                            data-matrix-limitation="digit" data-matrix="_">
                            <label>
                                <input type="text" name="code-sms-3" inputmode="numeric" placeholder="_">
                            </label>
                        </div>
                        <div class="custom-input custom-input--numeric" data-required data-validate-type="matrix"
                            data-matrix-limitation="digit" data-matrix="_">
                            <label>
                                <input type="text" name="code-sms-4" inputmode="numeric" placeholder="_">
                            </label>
                        </div>
                        <button id="sms-code-send" class="main-btn" type="submit" style="display: none;"></button>
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
