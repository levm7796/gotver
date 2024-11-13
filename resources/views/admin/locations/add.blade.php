@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Создание локации</h2>
        <form class="form-horizontal" method="POST" action="{{route('admin.locations.store')}}">
            @csrf
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Название:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Название" name="name" value="{{ old('name') }}">
                </div>
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <label class="control-label ">Название "Путеводитель по ...":</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Название" name="putevoditel_po" value="{{ old('putevoditel_po') }}">
                </div>
                @if ($errors->has('putevoditel_po'))
                    <span class="text-danger">{{ $errors->first('putevoditel_po') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Изображение:</label>
                <div class="ml-3 mr-3">
                    <hotel-image :type="'location'" :data="[ {{ json_decode(old('imgs')) }}]"></hotel-image>
                </div>
                @if ($errors->has('imgs'))
                    <span class="text-danger">{{ $errors->first('imgs') }}</span>
                @endif
            </div>

            <div class="form-row">
                <div class="form-group mt-3">
                    <label class="control-label col-sm-2" for="email">Иконка:</label>
                    <div class="col-sm-10">
                        <drop-down :elements="{{ json_encode($svgs) }}"
                            :selected="{{ json_encode(old('icon')) }}" :name="'icon'"></drop-down>
                        @if ($errors->has('icon'))
                            <span class="text-danger">{{ $errors->first('icon') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="control-label col-sm-2">Очередность:</label>
                    <div class="col-sm-10">
                        <input type="number" step="1" class="form-control" placeholder="Очередность" name="order"
                            value="{{ old('order', 500) }}">
                    </div>
                    @if ($errors->has('order'))
                        <span class="text-danger">{{ $errors->first('order') }}</span>
                    @endif
                </div>
            </div>

            <div class="form-group mt-3">
                <div class="form-floating col-sm-10">
                    <textarea class="form-control" name="seo_text" id="" cols="90" rows="5">{{ old('seo_text') }}</textarea>
                    <label for="floatingTextarea22">Сео текст</label>
                </div>
                @if ($errors->has('seo_text'))
                    <span class="text-danger">{{ $errors->first('seo_text') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <div class="form-floating col-sm-10">
                    <textarea name="btn_text" id="floatingTextarea22" class="form-control" id="" cols="90" rows="5" value="{{ old('btn_text') }}"></textarea>
                    <label for="floatingTextarea22">Текст кнопки селектора</label>
                </div>
                @if ($errors->has('btn_text'))
                    <span class="text-danger">{{ $errors->first('btn_text') }}</span>
                @endif
            </div>
            <div class="form-group row mt-3">
                <div class="col-sm-offset-2 col-sm-1">
                    <a href="{{route('admin.locations.index')}}" class="btn btn-default">Отмена</a>
                </div>
                <div class="col-sm-offset-2 col-sm-1">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
