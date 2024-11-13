@if (Auth::check())
    <div class="menu-user-group">
        <a class="menu-user-group-item menu-user-group-item--favorire" href="/profile">
            <svg class="menu-user-group-item__icon" width="24" height="24" aria-hidden="true">
                <use xlink:href="/img/sprite.svg#heart"></use>
            </svg><span class="menu-user-group-item__text">Избранное</span>
        </a>
        <a class="menu-user-group-item" href="/profile">
            <div class="menu-user-group-item__picture">
                <picture>
                    <source type="image/webp" srcset="{{ auth()->user()->validAvatar }}"><img
                        src="{{ auth()->user()->validAvatar }}" srcset="{{ auth()->user()->validAvatar }}"
                        width="36" height="36" alt="иконка юзера" loading="eager">
                </picture>
            </div><span class="menu-user-group-item__name">{{ auth()->user()->name }}</span>
        </a>
    </div>
@else
    <div class="menu-user-group">
        {{--
        <a class="menu-user-group-item menu-user-group-item--favorire">
            <svg class="menu-user-group-item__icon" width="24" height="24" aria-hidden="true">
                <use xlink:href="/img/sprite.svg#heart"></use>
            </svg><span class="menu-user-group-item__text">Избранное</span>
        </a>
        --}}
        <a class="menu-user-group-item" href="#" data-open-modal="login-to-account">
            <svg class="menu-user-group-item__icon" width="24" height="24" aria-hidden="true">
                <use xlink:href="/img/sprite.svg#user"></use>
            </svg>
            <span class="menu-user-group-item__text">Вход / Регистрация</span>
        </a>
    </div>
@endif
