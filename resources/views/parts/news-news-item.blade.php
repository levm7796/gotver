<div class="news-item item-favorite swiper-slide
    @if(Auth::check())
        @php
            $isFavorite = $newsFavorites ? $newsFavorites->contains($new->id) : false;
        @endphp
        {{ $isFavorite ? 'is-favorite' : '' }}
    @endif
    ">
    <div class="news-item__picture">
        <picture>
            {{-- <source type="image/webp" srcset="{{ $new->thumbImg }}"> --}}
                <img src="{{ $new->thumbImg }}" width="216" height="320" alt="фото новости" loading="lazy"
                    data-placeholder="/img/content/cards/card-01.png"
                    onerror="this.onerror=null; this.src=this.getAttribute('data-placeholder');">
        </picture>
    </div>
    <div class="news-item__overlay"></div>
    <div class="news-item__text"><a class="news-item__text-wrapper" href="{{ $new->myUrl() }}">
            <time datetime="{{ $new->created_at }}">{{  AppHelper::instance()->formatDate($new->created_at) }}</time>
            <p class="news-item__title">{{ $new->name }}</p>
            <p class="news-item__description">{{ $new->description }}</p>
        </a>
        <div class="news-item__labels">
            @if(isset(optional($new->tags)[0]))
                        <p class="label-item" data-tag="{{ $new->tags[0]->name }}" data-color="{{ ['red', 'green', 'purple', 'blue'][$new->tags[0]->id % 4] }}">{{ $new->tags[0]->name }}</p>
                    @endif
            @if(!empty($new->signature))
                <p class="label-item" data-tag="{{ $new->signature }}" data-color="gray">{{ $new->signature }}</p>
            @endif
        </div>
    </div>
    <button  onclick="@if (Auth::check())
                    favorite('{{ $new->getTable() }}', {{ $new->id }})
                @else
                    modals.open('login-to-account')
                @endif
            "
            class="action-item" type="button" @if(Auth::check())data-favorite="card" @endif

        ><span class="action-item__icon">
            <svg width="24" height="24" aria-hidden="true" style="pointer-events: none;">
                <use xlink:href="/img/sprite.svg#heart"></use>
            </svg></span>
    </button>
</div>
