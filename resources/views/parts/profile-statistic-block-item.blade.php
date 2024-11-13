<div class="statictic-block-item">
    <div class="statictic-block-item__object">
        <div class="statictic-block-item__object-wrapper">
            <div class="statictic-block-item__object-picture">
                <picture>
                    {{-- <source type="image/webp"
                        srcset="/img/content/cards/card-01.webp, /img/content/cards/card-01@2x.webp 2x"> --}}
                    <img src="/img/content/cards/card-01.png"
                        srcset="" width="96"
                        height="64" alt="фото объекта" loading="lazy">
                </picture>
            </div>
            <div class="statictic-block-item__object-wrapper-inner">
                <div class="statictic-block-item__object-name">
                    <p class="statictic-block-item__caption">Название:</p><a
                        class="statictic-block-item__object-name-link"
                        href="{{ $ad->hotel->myUrl() }}"><span>{{ $ad->hotel->name }}</span>
                        <svg width="12" height="12" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#link"></use>
                        </svg></a>
                </div>
                <div class="statictic-block-item__object-category">
                    <p class="statictic-block-item__caption">Категория:</p>
                    <p class="label-item" data-tag="Отели Твери" data-color="{{ ['red','blue', 'purple', 'green'][$ad->hotel->hub->id % 4] }}">{{ $ad->hotel->hub->name }}</p>
                </div>
            </div>
        </div>
        <div class="statictic-block-item__object-date-wrapper">
            <div class="statictic-block-item__object-create">
                <p class="statictic-block-item__caption">Создано:</p>
                <p class="statictic-block-item__date">{{ AppHelper::instance()->formatDate($ad->created_at) }}</p>
            </div>
            <div class="statictic-block-item__object-advertise">
                <p class="statictic-block-item__caption">Рекламируется до:</p>
                <p class="statictic-block-item__date">{{ AppHelper::instance()->formatDate($ad->end_date) }}</p>
            </div>
        </div>
    </div>
    <div class="statictic-block-item__total-activities">
        <div class="statictic-block-item__total-activities-item">
            <p>{{ $ad->hotel->viewsCount }}</p>
            <p>Просмотры</p>
        </div>
        <div class="statictic-block-item__separator"></div>
        <div class="statictic-block-item__total-activities-item">
            <p>{{ $ad->hotel->likesCount }}</p>
            <p>В избранном</p>
        </div>
        <div class="statictic-block-item__separator"></div>
        <div class="statictic-block-item__total-activities-item">
            <p>{{ $ad->hotel->link_click }}</p>
            <p>Переходов на сайт</p>
        </div>
        <div class="statictic-block-item__separator"></div>
        <div class="statictic-block-item__total-activities-item">
            <p>{{ $ad->hotel->phone_click }}</p>
            <p>Переходов по номеру</p>
        </div>
    </div>
    <div class="statictic-block-item__details">
        <div class="statictic-block-item__details-head">
            <p class="statictic-block-item__caption">Упоминается в:</p>
            <p class="statictic-block-item__caption">Категория:</p>
            <p class="statictic-block-item__caption">Просмотры:</p>
            <p class="statictic-block-item__caption">В избранном:</p>
            {{-- <p class="statictic-block-item__caption">Переходов на сайт:</p>
            <p class="statictic-block-item__caption">Переходов по номеру:</p> --}}
        </div>
        @foreach($ad->CNews() as $n)
        <div class="statictic-block-item__details-item">
            <a class="statictic-block-item__object-name-link" href="{{ $n->myUrl() }}">
                <span>{{ $n->name }}</span>
                <svg width="12" height="12" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#link"></use>
                </svg></a>
            <p class="label-item" data-tag="Что посмотреть" data-color="{{ ['red','blue', 'purple', 'green'][optional($n->hub)->id % 4] }}">{{ optional($n->hub)->name }}</p>
            <div class="statictic-block-item__details-criterion">
                <p class="statictic-block-item__caption">Просмотры:</p>
                <p class="statictic-block-item__value">{{ $n->viewsCount }}</p>
            </div>
            <div class="statictic-block-item__details-criterion">
                <p class="statictic-block-item__caption">В избранном:</p>
                <p class="statictic-block-item__value">{{ $n->lickesCount }}</p>
            </div>
            {{-- <div class="statictic-block-item__details-criterion">
                <p class="statictic-block-item__caption">Переходов на сайт:</p>
                <p class="statictic-block-item__value">23</p>
            </div> --}}
            {{-- <div class="statictic-block-item__details-criterion">
                <p class="statictic-block-item__caption">Переходов по номеру:</p>
                <p class="statictic-block-item__value">18</p>
            </div> --}}
        </div>
        @endforeach

        @foreach($ad->CArticles() as $n)
        <div class="statictic-block-item__details-item">
            <a class="statictic-block-item__object-name-link" href="{{ $n->myUrl() }}">
                <span>{{ $n->name }}</span>
                <svg width="12" height="12" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#link"></use>
                </svg></a>
            <p class="label-item" data-tag="Что посмотреть" data-color="{{ ['red','blue', 'purple', 'green'][optional($n->hub)->id % 4] }}">{{ optional($n->hub)->name }}</p>
            <div class="statictic-block-item__details-criterion">
                <p class="statictic-block-item__caption">Просмотры:</p>
                <p class="statictic-block-item__value">{{ $n->viewsCount }}</p>
            </div>
            <div class="statictic-block-item__details-criterion">
                <p class="statictic-block-item__caption">В избранном:</p>
                <p class="statictic-block-item__value">{{ $n->lickesCount }}</p>
            </div>
            {{-- <div class="statictic-block-item__details-criterion">
                <p class="statictic-block-item__caption">Переходов на сайт:</p>
                <p class="statictic-block-item__value">23</p>
            </div> --}}
            {{-- <div class="statictic-block-item__details-criterion">
                <p class="statictic-block-item__caption">Переходов по номеру:</p>
                <p class="statictic-block-item__value">18</p>
            </div> --}}
        </div>
        @endforeach
    </div>
</div>
