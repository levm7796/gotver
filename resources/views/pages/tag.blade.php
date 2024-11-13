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
        $breadcrumbs = [['url' => '/', 'name' => 'Главная'], ['name' => $tag->name]];
    @endphp
    @include('blocks.bread-crumbs')

    <section class="where-to-stay">
        <div class="container">
            <div class="main-title main-title--column">
                <h1>{{ $tag->name }} </h1>
                {{-- <p class="main-title__description">{{ $hub->seo_text }}</p> --}}
            </div>
            @include('parts.hub-filter-panel_and_grid-container', ['blockTags' => $uniqueHotelsTags, 'blockHotels' => $hotels, 'hubId' => null ])
        </div>
    </section>

    @if(optional($settings)['article_text'])
        <div class="container">
            <section class="text-content">
            {!! optional($settings)['article_text'] !!}
            </section>
        </div>
    @endif

    @include('parts.hub-tag-additional')

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
                                            ])
    @endif --}}

@endsection

