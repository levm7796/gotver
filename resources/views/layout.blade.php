<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trim($__env->yieldContent('title', 'Title')) }}</title>
    <meta name="description" content="{{ trim($__env->yieldContent('description', 'Description'))}}">
    <meta property="og:title" content="{{ trim($__env->yieldContent('title', 'Title')) }}">
    <meta property="og:description" content="{{ trim($__env->yieldContent('description', 'Description'))}}">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="icon" type="image/png" sizes="512x512" href="/favicon/android-chrome-512x512.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon/android-chrome-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest" crossorigin="use-credentials">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="preload" href="/fonts/UbuntuSans-Regular.woff" type="font/woff" as="font" crossorigin="anonymous">
    <link rel="preload" href="/fonts/UbuntuSans-Medium.woff" type="font/woff" as="font" crossorigin="anonymous">
    <link rel="preload" href="/fonts/PTSerif-Regular.woff" type="font/woff" as="font" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.min.css">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.2.2/css/froala_style.min.css' rel='stylesheet' type='text/css' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.2.2/css/plugins/image.min.css' rel='stylesheet' type='text/css' />
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/plugins/colors.min.css' rel='stylesheet' type='text/css' />

    {{-- <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' /> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--      axios       --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
      {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"> --}}
      <!-- Bootstrap Font Icon CSS -->
      {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"> --}}
    @yield('head-end', '')

  </head>
  <body>
        <div class="wrapper">
            @include('common.header')

            <main>
                @yield('content')
            </main>

            @include('common.footer')
        </div>


            @include('modals.feedback')
            @include('modals.login-to-account')
            @include('modals.user-registration')
            @include('modals.sms-code')
            {{-- @include('modals.user-success') --}}
            @include('modals.spasibo')

            @include('modals.card-slider')
            @if($page_story)
                @foreach($page_story->content as $key => $story)
                    @include('modals.main-slider', ["key" => $key, "story" => $story])
                @endforeach
            @endIf

            @yield('body-end', '')

            <script src="/js/vendor.min.js"></script>
            <script src="/js/main.min.js"></script>
           <script src="/js/external.js"></script>
        {{-- <script src="https://api-maps.yandex.ru/2.1/?apikey=39d99a70-dcc3-427d-9e95-c1e01263fb84&amp;lang=ru_RU"></script> --}}
{{--            <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'></script>--}}
{{--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>--}}

<style>
    .card-item__text, .news-item__text{
        position: absolute;
        bottom: 0;
    }
    .fr-img-caption  .fr-inner,
    .text-content .fr-inner
    {
        margin-top: 16px;
        font-size: 16px;
        font-style: italic;
        line-height: 24px;
    }
    .article__section > p > img,
    .text-content p > img
    {
        margin-bottom: 30px;
    }
    .article__section p:has(.fr-fic),
    .text-content p:has(.fr-fic)
    {
        display: flex;
        justify-content: center;
    }
    .article__section p:has(.fr-fic.fr-fir),
    .text-content p:has(.fr-fic.fr-fir)
    {
        display: flex;
        justify-content: flex-end;
    }
    .article__section p:has(.fr-fic.fr-fil),
    .text-content p:has(.fr-fic.fr-fil)
    {
        display: flex;
        justify-content: flex-start;
    }
    </style>
    </body>
</html>
