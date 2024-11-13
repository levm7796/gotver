@extends('layout')

@section('title')Go-Tver.ru. Страница - 404.@endsection
@section('description')GoTver — Ваш путеводитель по Тверской области@endsection

@section('head-end')
@endsection

@section('body-end')
@endsection

@section('content')
    <div class="container">
        <div class="error-404">
            <div class="error-404__wrapper"><img src="/img/svg/error-404.svg" width="450" height="450" alt="error">
                <div class="error-404__info">
                    <h1 class="error-404__title">Упс! Такую страницу не удалось найти</h1>
                    <p class="error-404__description">К сожалению, страница, которую Вы запросили, не найдена. Она может быть
                        временно недоступна, перемещена или удалена.</p>
                    <a class="main-btn" href="/"><span>Вернуться на главную</span>
                        <svg width="40" height="40" aria-hidden="true">
                            <use xlink:href="/img/sprite.svg#arrow-black"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
