@extends('layout')

@section('title')
    Go-Tver.ru. Мой аккаунт.
@endsection
@section('description')
    GoTver — Ваш путеводитель по Тверской области
@endsection

@section('head-end')
@endsection

@section('body-end')
@endsection

@section('content')
    <section class="my-account">
        <div class="container">
            <h1 class="my-account__title">Мой аккаунт</h1>
            <div class="my-account__tabs no-transition-global" data-tabs="parent" data-delay="300" data-tabs-total>
                <div class="my-account__menu">
                    <div class="my-account__user">
                        <div class="my-account__user-avatar">
                            <picture>
                                <source type="image/webp"
                                    srcset="{{ $user->validAvatar }}">
                                <img src="{{ $user->validAvatar }}"
                                    srcset="{{ $user->validAvatar }}" width="60" height="60"
                                    alt="иконка пользователя" loading="eager">
                            </picture>
                        </div>
                        <div class="my-account__user-info">
                            <p class="my-account__user-name">{{ $user->name }}</p>
                            <p class="my-account__user-status">
                                @if($user->role_id == 1)
                                    Админ
                                @elseif($user->role_id == 2)
                                    Модератор
                                @elseif($user->role_id == 3)
                                    Пользователь
                                @elseif($user->role_id == 4)
                                    Партнер
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="my-account__navigation">
                        <div class="my-account__controls" data-tabs="controls">
                            <button class="my-account__control is-active" type="button" data-tabs="control">
                                <svg width="24" height="24" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#heart-acc"></use>
                                </svg><span>Избранные места</span>
                            </button>
                            <button class="my-account__control" type="button" data-tabs="control">
                                <svg width="24" height="24" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#comment-acc"></use>
                                </svg><span>Мои комментарии</span>
                            </button>
                            @php
                            $adverts = auth()->user()->advertisings;
                            @endphp
                            @if(count($adverts))
                            <button class="my-account__control" type="button" data-tabs="control">
                                <svg width="24" height="24" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#statistic-acc"></use>
                                </svg><span>Рекламная статистика</span>
                            </button>
                            @endif
                            <button class="my-account__control" type="button" data-tabs="control">
                                <svg width="24" height="24" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#setting-acc"></use>
                                </svg><span>Настройки</span>
                            </button>
                        </div><a class="my-account__exit" href="/logout">
                            <svg width="24" height="24" aria-hidden="true">
                                <use xlink:href="/img/sprite.svg#logout-acc"></use>
                            </svg><span>Выход</span></a>
                    </div>
                </div>
                <div class="my-account__content" data-tabs="content">
                    <div class="my-account__element for-load" data-tabs="element">
                        <div class="grid-container grid-container--account" data-showmore="items">
                            <div class="grid-container__inner" data-showmore-content="5">
                                @foreach(auth()->user()->favorites['all'] as $favorite)
                                @php
                                    $item = $favorite->getItem()
                                @endphp
                                <div class="card-item item-favorite is-favorite">
                                    <div class="card-item__picture">
                                        <picture>
                                            <source type="image/webp"
                                                srcset="/img/content/cards/card-01.webp, /img/content/cards/card-01@2x.webp 2x">
                                            <img src="/img/content/cards/card-01.png"
                                                srcset="/img/content/cards/card-01@2x.png 2x" width="456" height="278"
                                                alt="фото новости" loading="lazy">
                                        </picture>
                                    </div>
                                    <div class="card-item__overlay"></div>
                                    <div class="card-item__text"><a class="card-item__text-wrapper" href="{{ $item->myUrl() }}">
                                            <p class="card-item__title">{{ $item->name }}</p>
                                            <p class="card-item__description">{{ strip_tags($item->description) }}</p>
                                        </a>
                                        <div class="card-item__info-panel">
                                            <div class="card-item__labels">
                                                <p class="label-item" data-tag="Отели Твери" data-color="{{['red', 'green', 'purple', ][$item->hub_id % 3]}}">{!! $item->hub->name !!}</p>
                                            </div>
                                            <div class="activity-panel">
                                                @if($item->views)
                                                <div class="activity-panel__item">
                                                    <svg width="20" height="20" aria-hidden="true">
                                                        <use xlink:href="/img/sprite.svg#eye"></use>
                                                    </svg><span>{{ $item->viewsCount }}</span>
                                                </div>
                                                @endif
                                                @if($item->likes)
                                                <div class="activity-panel__item">
                                                    <svg width="20" height="20" aria-hidden="true">
                                                        <use xlink:href="/img/sprite.svg#like"></use>
                                                    </svg><span>{{ $item->likesCount }}</span>
                                                </div>
                                                @endif
                                                @if($item->comments)
                                                <div class="activity-panel__item">
                                                    <svg width="20" height="20" aria-hidden="true">
                                                        <use xlink:href="/img/sprite.svg#comment"></use>
                                                    </svg><span>{{ $item->commentsCount }}</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <button class="action-item" type="button" data-favorite="card"><span
                                            class="action-item__icon">
                                            <svg width="24" height="24" aria-hidden="true">
                                                <use xlink:href="/img/sprite.svg#heart"></use>
                                            </svg></span>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            @if(count(auth()->user()->favorites['all']) > 10)
                            <button class="button-more" hidden data-showmore-button type="button">
                                <svg width="24" height="24" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#arrow-more"></use>
                                </svg><span class="button-more__more">Показать еще</span><span
                                    class="button-more__less">Спрятать</span>
                            </button>
                            @endif
                        </div>
                    </div>
                    <div class="my-account__element" data-tabs="element">
                        <div class="comments-account" data-showmore="items">
                            <div class="comments-account__inner" data-showmore-content="6">
                                @foreach(auth()->user()->comments as $comment)
                                    @include('parts.profile-comment')
                                @endforeach
                            </div>
                            <button class="button-more" hidden data-showmore-button type="button">
                                <svg width="24" height="24" aria-hidden="true">
                                    <use xlink:href="/img/sprite.svg#arrow-more"></use>
                                </svg><span class="button-more__more">Показать еще</span><span
                                    class="button-more__less">Спрятать</span>
                            </button>
                        </div>
                    </div>
                    @if(count($adverts))
                    <div class="my-account__element" data-tabs="element">
                        <div class="statictic-block-list">
                            {{--
                            <div class="statictic-block-list__filter">
                                <p class="statictic-block-list__filter-text">Показывать статистику:</p>
                                <div class="custom-select" data-select data-name="object-select">
                                    <button class="custom-select__button" type="button"
                                        aria-label="Выберите одну из опций"><span
                                            class="custom-select__text"></span><span
                                            class="custom-select__icon"></span></button>
                                    <ul class="custom-select__list" role="listbox">
                                        <li class="custom-select__item" tabindex="0" data-select-value="parameter-1"
                                            aria-selected="true" role="option">За последний месяц</li>
                                        <li class="custom-select__item" tabindex="0" data-select-value="parameter-2"
                                            aria-selected="false" role="option">За последний год</li>
                                        <li class="custom-select__item" tabindex="0" data-select-value="parameter-3"
                                            aria-selected="false" role="option">За последнюю неделю</li>
                                    </ul>
                                </div>
                            </div>
                            --}}
                            @foreach($adverts as $ad)
                                @include('parts.profile-statistic-block-item')
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="my-account__element" data-tabs="element">
                        <div class="setting" data-form-validate data-callback="base">
                            <form action="/" method="post" enctype="multipart/form-data" data-form="edit-account">
                                <div class="setting__section-wrap">
                                    <div class="setting__section">
                                        <div class="setting__decription">
                                            <p class="setting__title">Аватар профиля</p>
                                            <p class="setting__text">Современные технологии достигли такого уровня,
                                                что постоянный количественный рост и сфера нашей.</p>
                                        </div>
                                        <div class="setting__fields">
                                            <div class="avatar">
                                                <label for="files-image" tabindex="0"><img
                                                        src="{{ $user->validAvatar }}" width="96"
                                                        height="96" alt="картинка аватара"></label>
                                                <input class="visually-hidden" type="file" id="files-image"
                                                    name="files-image" accept=".jpg, .jpeg, .png, .webp"
                                                    tabindex="-1">
                                                <input class="visually-hidden" type="hidden" id="files-image-help" name="files-image-help" value="{{ $user->avatar }}">
                                                <div class="avatar__buttons">
                                                    <div class="avatar__button" data-avatar-edit>
                                                        <svg width="24" height="24" aria-hidden="true">
                                                            <use xlink:href="/img/sprite.svg#edit"></use>
                                                        </svg><span>Изменить</span>
                                                    </div>
                                                    <div class="avatar__button" data-avatar-delete>
                                                        <svg width="24" height="24" aria-hidden="true">
                                                            <use xlink:href="/img/sprite.svg#delete"></use>
                                                        </svg><span>Удалить</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="setting__section">
                                        <div class="setting__decription">
                                            <p class="setting__title">Персональная информация</p>
                                            <p class="setting__text">В частности, повышение уровня гражданского сознания
                                                выявляет срочную потребность соответствующих условий активизации.</p>
                                        </div>
                                        <div class="setting__fields">
                                            <div class="custom-input" data-validate-type="phone">
                                                <label><span class="custom-input__label">Номер телефона:</span>
                                                    <input type="tel" name="phone"
                                                        placeholder="+7 (985) 505-45-18"
                                                        value="{{ $user->formattedPhone }}"
                                                        >
                                                </label>
                                            </div>
                                            <div class="custom-input" data-required data-validate-type="text">
                                                <label><span class="custom-input__label">Имя</span>
                                                    <input type="text" name="name" placeholder="Дмитрий"
                                                        value="{{ $user->name }}"
                                                    >
                                                </label>
                                            </div>
                                            <div class="custom-input" data-required data-validate-type="email">
                                                <label><span class="custom-input__label">E-mail</span>
                                                    <input type="email" name="email"
                                                        placeholder="example@mail.ru"
                                                        value="{{ $user->email }}"
                                                        >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="setting__section">
                                        <div class="setting__decription">
                                            <p class="setting__title">Пароль</p>
                                            <p class="setting__text">Учитывая ключевые сценарии поведения, перспективное
                                                планирование играет определяющее значение для позиций.</p>
                                        </div>
                                        <div class="setting__fields">
                                            <div class="custom-input" data-required data-validate-type="text">
                                                <label><span class="custom-input__label">Введите старый пароль:</span>
                                                    <input type="password" name="old-password" placeholder=" ">
                                                </label>
                                            </div>
                                            <div class="custom-input" data-validate-type="text">
                                                <label><span class="custom-input__label">Введите новый пароль:</span>
                                                    <input type="password" name="new-password" placeholder=" ">
                                                </label>
                                            </div>
                                            <div class="custom-input" data-validate-type="text">
                                                <label><span class="custom-input__label">Введите новый пароль еще
                                                        раз</span>
                                                    <input type="password" name="repeat-password" placeholder=" ">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="setting__section">
                                        <div class="setting__decription">
                                            <p class="setting__title">Уведомления</p>
                                            <p class="setting__text">Современные технологии достигли такого уровня,
                                                что постоянный количественный рост и сфера нашей.</p>
                                        </div>
                                        <div class="setting__fields">
                                            <div class="custom-toggle custom-toggle--checkbox">
                                                <label>
                                                    <input type="checkbox" name="email-delivery" @if($user->permission_email)checked @endif><span
                                                        class="custom-toggle__icon">
                                                        <svg width="12" height="8" aria-hidden="true">
                                                            <use xlink:href="/img/sprite.svg#check"></use>
                                                        </svg></span><span class="custom-toggle__label">Разрешить
                                                        Email-рассылка новостей — это регулярные письма с последними
                                                        новостями компании, её продуктами и услугами, а также другой
                                                        полезной информацией.</span>
                                                </label>
                                            </div>
                                            <div class="custom-toggle custom-toggle--checkbox">
                                                <label>
                                                    <input type="checkbox" name="sms-delivery" @if($user->permission_sms)checked @endif><span
                                                        class="custom-toggle__icon">
                                                        <svg width="12" height="8" aria-hidden="true">
                                                            <use xlink:href="/img/sprite.svg#check"></use>
                                                        </svg></span><span class="custom-toggle__label">Разрешить
                                                        SMS-рассылка новостей — это регулярные письма с последними новостями
                                                        компании, её продуктами и услугами, а также другой полезной
                                                        информацией.</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="main-btn" type="submit"><span>Сохранить изменения</span>
                                    <svg width="40" height="40" aria-hidden="true">
                                        <use xlink:href="/img/sprite.svg#arrow-black"></use>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
