{{-- <div class="card-item item-favorite swiper-slide">
    <div class="card-item__picture">
        <picture>
            <source type="image/webp"
                srcset="/img/content/cards/card-03.webp, img/content/cards/card-03@2x.webp 2x"><img
                src="/img/content/cards/card-03.png" srcset="/img/content/cards/card-03@2x.png 2x"
                width="456" height="278" alt="фото новости" loading="lazy">
        </picture>
    </div>
    <div class="card-item__overlay"></div>
    <div class="card-item__text"><a class="card-item__text-wrapper" href="#">
            <p class="card-item__title">Метрополь</p>
            <p class="card-item__description">Господа, убеждённость некоторых оппонентов требует
                определения и уточнения форм воздействия. Каждый из нас понимает очевидную вещь:
                консультация с широким активом воздействия.</p>
        </a>
        <div class="card-item__info-panel">
            <div class="card-item__labels">
                <p class="label-item" data-tag="Отели Твери" data-color="red">Отели Твери</p>
            </div>
            <div class="activity-panel">
                <div class="activity-panel__item">
                    <svg width="20" height="20" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#eye"></use>
                    </svg><span>1 473</span>
                </div>
                <div class="activity-panel__item">
                    <svg width="20" height="20" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#like"></use>
                    </svg><span>215</span>
                </div>
                <div class="activity-panel__item">
                    <svg width="20" height="20" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#comment"></use>
                    </svg><span>31</span>
                </div>
            </div>
        </div>
    </div>
    <button class="action-item" type="button" data-favorite="card"><span
            class="action-item__icon">
            <svg width="24" height="24" aria-hidden="true">
                <use xlink:href="/img/sprite.svg#heart"></use>
            </svg></span>
    </button>
</div> --}}
@include('parts.hub-hotel-items', ['hotels' => $hotels, 'custom_tag' => $tag])
@if(!is_null($tag))
<div class="add-item">
    <p class="add-item__title">Больше предложений на выбор</p>
    <p class="add-item__description">Каждый день мы добавляем десятки новых вариантов, чтобы у вас
        была максимальная подборка в нашем сервисе</p>
    <a class="main-btn" href="{{ $tag->myUrl() }}"><span>Посмотреть всё</span>
        <svg width="40" height="40" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#arrow-black"></use>
        </svg>
    </a>
</div>
@endif
