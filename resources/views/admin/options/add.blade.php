@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Создание услуги</h2>
        <form class="form-horizontal" method="POST" action="{{route('admin.options.store')}}">
            @csrf
            <div class="form-group mt-3">
                <label class="control-label col-sm-2" for="email">Иконка:</label>
                <div class="col-sm-10">
                    <drop-down :elements="{{ json_encode($svgs) }}" :selected="{{ json_encode(old('ico')) }}" :name="'ico'"></drop-down>
                    @if ($errors->has('ico'))
                        <span class="text-danger">{{ $errors->first('ico') }}</span>
                    @endif
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Название:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Название" name="content" value="{{ old('content') }}">
                </div>
                @if ($errors->has('content'))
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                @endif
            </div>

            <div class="form-group row mt-3">
                <div class="col-sm-offset-2 col-sm-1">
                    <a href="{{route('admin.options.index')}}" class="btn btn-default">Отмена</a>
                </div>
                <div class="col-sm-offset-2 col-sm-1">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
