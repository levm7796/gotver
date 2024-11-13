@extends('admin.layout')

@section('content')
@if (auth()->check())
    <div class="container mt-5">
        <div class="alert alert-info" role="alert">
            Вы уже аутентифицированы как {{ auth()->user()->name }}.
        </div>
        <form action="{{ route('logout') }}" method="get">
            @csrf
            <button type="submit" class="btn btn-warning">Выйти</button>
        </form>
    </div>
@else
    <div class="container mt-5">
        <form action="/login-admin" method="post" class="needs-validation" novalidate>
            @csrf

            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="phone" class="form-control" name="phone" id="email" value="+71234567890" required>


            <div class="mb-4">
                <label for="password" class="form-label">Пароль:</label>
                <input type="password" class="form-control" name="password" id="password" value="admin" required>
            </div>

            @if($errors->has('email'))
                    <span class="alert alert-danger mb-2" role="alert">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
    </div>
@endif
@endsection
