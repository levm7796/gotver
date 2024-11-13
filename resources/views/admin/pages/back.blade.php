@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Редактирование административных настроек</h2>
        <form class="form-horizontal" method="POST" >
            @csrf

            <div class="form-group mt-3">
                <label class="control-label col-sm-12">Почта администратора для уведомлений</label>
                <div class="col-sm-10">
                    <input type="mail" class="form-control" placeholder="Email" name="mail"
                        value="{{ old('mail', optional($settings)['mail']) }}">
                </div>
                @if ($errors->has('mail'))
                    <span class="text-danger">{{ $errors->first('mail') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <label class="control-label col-sm-12">API key Оптимизатора картинок tinify.com</label>
                <div class="col-sm-10">
                    <input type="tinify" class="form-control" placeholder="1q2w3e4r5t6y7u8i9o0p" name="tinify"
                        value="{{ old('tinify', optional($settings)['tinify']) }}">
                </div>
                @if ($errors->has('mail'))
                    <span class="text-danger">{{ $errors->first('mail') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <a href="/admin/gen-sitemap" type="submit" class="btn btn-info">Обновить карту сайта</a>
            </div>
            <div class="form-group row mt-3">
                <div class="col-sm-offset-2 col-sm-1">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
