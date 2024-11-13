@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Редактирование Главные настройки</h2>
        <form class="form-horizontal" method="POST" >
            @csrf

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Ссылка дзен:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Ссылка дзен" name="dzen"
                        value="{{ old('dzen', optional($settings)['dzen']) }}">
                </div>
                @if ($errors->has('dzen'))
                    <span class="text-danger">{{ $errors->first('dzen') }}</span>
                @endif
            </div>

            <link-generator :old=" {{ old('roads', optional($settings)['roads']) }}" :title="'Направления'" :name="'roads'"></link-generator>

            <link-generator :old=" {{ old('users', optional($settings)['users']) }}" :title="'Пользователям'" :name="'users'" :svgs="{{ json_encode($svgs) }}" :withico="true" ></link-generator>

            <div class="form-group row mt-3">
                <div class="col-sm-offset-2 col-sm-1">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
