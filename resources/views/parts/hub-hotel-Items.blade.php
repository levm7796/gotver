@if (Auth::check())
    @php
        $user = Auth::user();
        $newsFavorites = optional($user->favorites)['hotels'];
    @endphp
@endif
@foreach($hotels as $hotel)
<div class="card-item item-favorite swiper-slide
    @if (Auth::check())
    @php
        $isFavorite = $newsFavorites ? $newsFavorites->contains($hotel->id) : false;
    @endphp
        {{ $isFavorite ? 'is-favorite' : '' }}
    @endif
">
    <div class="card-item__picture">
        <picture>
            {{-- <source type="image/webp" srcset="img/content/cards/card-01.webp, img/content/cards/card-01@2x.webp 2x"> --}}
                @php
                    $img = optional($hotel->images())[0];
                @endphp
                <img src="{{ $img ? $img : '/img/content/cards/card-01.png' }}" srcset="{{ $img ? $img : '/img/content/cards/card-01@2x.png 2x'}}"
                width="456" height="278" alt="фото новости" loading="lazy">
        </picture>
    </div>
    <div class="card-item__overlay"></div>
    <div class="card-item__text">
        <a class="card-item__text-wrapper" href="{{ $hotel->myUrl() }}">
            <p class="card-item__title">{{ $hotel->name }} {{ $hotel->id }}</p>
            <p class="card-item__description">{{ $hotel->description }}</p>
        </a>
        <div class="card-item__info-panel">
            <div class="card-item__labels">
                @if(isset($custom_tag))
                    <p class="label-item" data-tag="{{ $custom_tag->name }}" data-color="{{ ['red', 'green', 'purple', 'blue'][$custom_tag->id % 4] }}">{{ $custom_tag->name }}</p>
                @else
                    @if(isset(optional($hotel->tags)[0]))
                        <p class="label-item" data-tag="{{ $hotel->tags[0]->name }}" data-color="{{ ['red', 'green', 'purple', 'blue'][$hotel->tags[0]->id % 4] }}">{{ $hotel->tags[0]->name }}</p>
                    @endif
                @endif
            </div>
            <div class="activity-panel">
                @if($hotel->views)
                <div class="activity-panel__item">
                    <svg width="20" height="20" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#eye"></use>
                    </svg><span>{{ $hotel->viewsCount }}</span>
                </div>
                @endif
                @if($hotel->likes)
                <div class="activity-panel__item">
                    <svg width="20" height="20" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#like"></use>
                    </svg><span>{{ $hotel->likesCount }}</span>
                </div>
                @endif
                @if($hotel->comments)
                <div class="activity-panel__item">
                    <svg width="20" height="20" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#comment"></use>
                    </svg><span>{{ $hotel->commentsCount }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
    <button
        onclick="@if (Auth::check())
                    favorite('{{ $hotel->getTable() }}', {{ $hotel->id }})
                @else
                    modals.open('login-to-account')
                @endif
            "
     class="action-item" type="button" @if (Auth::check())data-favorite="card"@endif>
     <span class="action-item__icon">
        <svg width="24" height="24" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#heart"></use>
        </svg></span>
    </button>
</div>
@endforeach
