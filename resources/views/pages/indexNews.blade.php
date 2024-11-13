@extends('layout')
@section('title')
    {{ $news->title }}
@endsection
@section('description')
    {{ $news->description }}
@endsection

@section('head-end')
    <script src="https://api-maps.yandex.ru/2.1/?apikey=39d99a70-dcc3-427d-9e95-c1e01263fb84&amp;lang=ru_RU"></script>
@endsection

@section('body-end')
    @include('modals.tell-about', ['name' => $news->name, 'url' => url()->current()])
@endsection
@section('content')
    @php
        $breadcrumbs = [
            ['url' => '/', 'name' => 'Главная'],
            ['url' => $news->location->myUrl() , 'name' => $news->location->name],
            ['url' =>  $news->hub->myUrl() , 'name' => $news->hub->name],
            ['name' => $news->name]
        ];
    @endphp
    @if(!isset($excludeBread))
        @include('blocks.bread-crumbs')
    @endif

    @include('parts.news-content')

    <section class="tags-additional">
        <div class="container">
            <div class="main-title">
                <p>Дополнительные теги</p>
            </div>
            <div class="tags-additional__wrapper">

                @foreach($news->getAllTags() as $key => $tg)
                <a class="tag-item" href="{{ $tg->myUrl() }}" data-tag="{{ $tg->name }}" data-color="{{ ['red', 'green', 'purple', 'blue'][$key % 4] }}">
                    <svg width="16" height="16" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#tag"></use>
                    </svg><span>{{ $tg->name }}</span>
                </a>
                @endforeach
            </div>
            <a class="main-btn" href="{{ $news->location->myUrl() }}"><span>Все туристические места {{ $news->location->name }}</span>
                <svg width="40" height="40" aria-hidden="true">
                  <use xlink:href="/img/sprite.svg#arrow-black"></use>
                </svg>
              </a>
        </div>
    </section>

    @include('parts.news-see-also', ['news' => $news->someItself()])

@endsection
