<section class="tags-additional">
    <div class="container">
        <div class="main-title">
            <h2>@if(!empty($settings['titleTags'])){!! $settings['titleTags'] !!} @else Дополнительные теги @endif</h2>
        </div>
        <div class="tags-additional__wrapper">
            @foreach($tags as $tag)
            <a class="tag-item" href="{{$tag->myUrl()}}" data-tag="{{$tag->name}}"
                data-color="purple">
                <svg width="16" height="16" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#tag"></use>
                </svg><span>{{$tag->name}}</span>
            </a>
            @endforeach
            @if(isset($url))
            <a class="main-btn" href="{{ $url }}"><span>Все туристические места {{ $name }}</span>
                <svg width="40" height="40" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#arrow-black"></use>
                </svg>
            </a>
            @endif
        </div>
    </div>
</section>
