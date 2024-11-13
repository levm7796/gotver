@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Редактирование шапку меню</h2>
        <form class="form-horizontal" method="POST" action="{{ route('admin.header.edit') }}">
            @csrf

            <link-generator :title="'Направления'" :name="'direction'" :old="{{ old('direction', optional($settings)['direction']) }}"></link-generator>

            <link-generator :title="'Пользователям'" :name="'users'" :old="{{ old('users', optional($settings)['users']) }}" :withico="true"></link-generator>

            <div class="form-group row mt-3">
                <div class="col-sm-offset-2 col-sm-1">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
