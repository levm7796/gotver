<!DOCTYPE html>
<html lang="ru">

<head>
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://kit.fontawesome.com/f75ab26951.js" crossorigin="anonymous" defer></script>
    {{-- bootstrap start --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="/bootstrap/bootstrap.min.css" >
    <script src="/bootstrap/bootstrap.bundle.min.js" ></script>
    <link rel="stylesheet" href="/bootstrap/bootstrap-icons.min.css" >
    <!-- include libraries(jQuery, bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

<!-- Latest compiled and minified CSS -->
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">--}}

    <!-- Latest compiled and minified JavaScript -->
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>--}}

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/i18n/defaults-*.min.js"></script>--}}

    <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/plugins/colors.min.css' rel='stylesheet' type='text/css' />

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"> --}}
    <!-- Bootstrap Font Icon CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"> --}}

    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> --}}

    <style>
        .table td,
        .table th {
          vertical-align: middle;
        }
        [role="navigation"] svg {
            width: 20px;
        }
        [role="navigation"] .hidden{
            opacity: 1;
            pointer-events: auto;
        }
        .note-toolbar {
            z-index: 1;
        }
      </style>
    @yield('headers')

</head>

<body >
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <span>
            <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/admin/">Site</a>
        </span>
        @if (auth()->check())
        <div class="navbar-nav">
          <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="/logout">Sign out</a>
          </div>
        </div>
        @endif
      </header>
      <div class="container-fluid">
            <div class="row">
            @if (auth()->check())
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.users.index')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                Пользователи
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="/admin/main/">
                                    <i class="bi bi-app"></i>
                                    Главная
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/locations/">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16"><path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/><path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                                    Локации
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/hubs/">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16"><path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3"/></svg>
                                    Хабовые
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/tags/">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-hash" viewBox="0 0 16 16">
                                        <path d="M8.39 12.648a1 1 0 0 0-.015.18c0 .305.21.508.5.508.266 0 .492-.172.555-.477l.554-2.703h1.204c.421 0 .617-.234.617-.547 0-.312-.188-.53-.617-.53h-.985l.516-2.524h1.265c.43 0 .618-.227.618-.547 0-.313-.188-.524-.618-.524h-1.046l.476-2.304a1 1 0 0 0 .016-.164.51.51 0 0 0-.516-.516.54.54 0 0 0-.539.43l-.523 2.554H7.617l.477-2.304c.008-.04.015-.118.015-.164a.51.51 0 0 0-.523-.516.54.54 0 0 0-.531.43L6.53 5.484H5.414c-.43 0-.617.22-.617.532s.187.539.617.539h.906l-.515 2.523H4.609c-.421 0-.609.219-.609.531s.188.547.61.547h.976l-.516 2.492c-.008.04-.015.125-.015.18 0 .305.21.508.5.508.265 0 .492-.172.554-.477l.555-2.703h2.242zm-1-6.109h2.266l-.515 2.563H6.859l.532-2.563z"/>
                                    </svg>
                                    Тэги
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="/admin/anonses/">
                                    <i class="bi bi-chat-left-text"></i>
                                    Анонсы статей
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/articles/">
                                    <i class="bi bi-chat-left-text"></i>
                                    Статьи
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/settings/all-articles">
                                    <i class="bi bi-chat-left-text"></i>
                                    Страница статей
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/news/">
                                    <i class="bi bi-newspaper"></i>
                                    Новости
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/settings/all-news/">
                                    <i class="bi bi-newspaper"></i>
                                    Страница новостей
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/options">
                                    <i class="bi bi-wifi"></i>
                                    Услуги объектов
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/hotels/">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                                    </svg>
                                    Объекты
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/histories">
                                    <i class="bi bi-calendar-heart"></i>
                                    Истории
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/settings/common">
                                    <i class="bi bi-inboxes"></i>
                                    Обеще
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/settings/tos">
                                    <i class="bi bi-ui-checks"></i>
                                    Политика конфиденциальности
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/settings/tac">
                                    <i class="bi bi-ui-checks"></i>
                                    Правила пользования платформой
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/advertisings/">
                                    <i class="bi bi-badge-ad"></i>
                                    Пользовательская реклама
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/settings/svg-editor/">
                                    <i class="bi bi-filetype-svg"></i>
                                    Редактор SVG спрайта
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/settings/back">
                                    <i class="bi bi-gear"></i>
                                    Настройки
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/loging/">
                                    <i class="bi bi-database-fill-gear"></i>
                                    Логи
                                </a>
                            </li>

                        </ul>
                    </div>
                </nav>
            @endif
            <main id="app" class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                @yield('content')
            </main>
        </div>
      </div>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'></script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/plugins/colors.min.js'></script>
      @include('admin.deletePanel')
      @include('admin.restartPanel')
    <script src="{{ mix('/adminjs/app.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script>
        $('.selectpicker').selectpicker();
        // new FroalaEditor('.editor', {placeholderText: 'Текст...', pastePlain: true})
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $(document).ready(function(){
                $('[data-bs-toggle="popover"]').popover();
            });
        });
    </script>
    @yield('end-page')
</body>
</html>
