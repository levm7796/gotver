    @extends('layout')

@section('title')
    {{ optional($settings)['title'] }}
@endsection
@section('description')
    {{ optional($settings)['description'] }}
@endsection

@section('head-end')
    @if ($article['show'])
        <script src="https://api-maps.yandex.ru/2.1/?apikey=39d99a70-dcc3-427d-9e95-c1e01263fb84&amp;lang=ru_RU"></script>
    @endif
@endsection

@section('body-end')
@endsection

@section('content')
    @php
        $breadcrumbs = [['url' => '/', 'name' => 'Главная']];
        if(!is_null($hub->location))
            $breadcrumbs[] = ['url' => $hub->location->myUrl(), 'name' => $hub->location->name];
        $breadcrumbs[] = ['name' => $hub->name];
    @endphp
    @include('blocks.bread-crumbs')
    <section class="where-to-stay">
        <div class="container">
            <div class="main-title main-title--column">
                <h1>
                    @if(!empty($settings['h1'])){!! $settings['h1'] !!}@else
                    {{ $hub->name }}
                    @endif

                </h1>
                <p class="main-title__description">{!! $hub->seo_text !!}</p>
            </div>
            @if($settings['block_logic'] == 0)
                @include('parts.hub-filter-panel_and_grid-container', ['blockTags' => $uniqueHotelsTags, 'blockHotels' => $hub->hotels, 'hubId' => $hub->id ])
            @else
                @include('parts.hub-filter-panel_and_grid-container-forarticle', ['blockTags' => $uniqueHotelsTags, 'blockHotels' => $hub->articles, 'hubId' => $hub->id ])
            @endif
        </div>
    </section>


    {{-- @if($article['show'])
    <style>
        .card-object__comments{
            margin-top: 80px;
        }
    </style>
        @include('parts.news-content', [
                                        'news' => $article['article'],
                                        'tags' => $article['tags'],
                                        'comments' => $article['comments'],
                                        'blocks' => $article['blocks'],
                                        'h1Normal' => true,
                                        ])
    @endif --}}

    @if(optional($settings)['article_text'])
        <div class="container">
            <section class="text-content">
            {!! optional($settings)['article_text'] !!}
            </section>
        </div>
    @endif

    @include('parts.hub-tag-additional', ['url' => optional($hub->location)->myUrl(), 'name' => optional($hub->location)->name])
    @if(isset($articles))
        @include('parts.news-see-also', ['news' => $articles])
    @endif

@endsection
