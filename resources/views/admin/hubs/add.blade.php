@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h2>Создание хабовой</h2>
    <form class="form-horizontal" method="POST" action="{{route('admin.hubs.store')}}">
        @csrf

        <location-selector :elements="{{json_encode($locations)}}" :selected="{{json_encode(old('location_id'))}}" :name="'location_id'"></location-selector>
        @if ($errors->has('location_id'))
            <span class="text-danger">{{ $errors->first('location_id') }}</span>
        @endif

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
            <label class="control-label col-sm-2" for="email">Иконка:</label>
            <div class="col-sm-10">
                <drop-down :elements="{{ json_encode($svgs) }}" :selected="{{ json_encode(old('icon')) }}" :name="'icon'"></drop-down>
                @if ($errors->has('icon'))
                    <span class="text-danger">{{ $errors->first('icon') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group mt-3">
            <div class="col-sm-10">
                <label for="qwet" >Описание:</label>
                <Froala class="form-control" :name="'seo_text'" id="qwet" :value="{{ old('seo_text') }}" :placeholder="'Описание'"></Froala>
            </div>
            @if ($errors->has('seo_text'))
                <span class="text-danger">{{ $errors->first('seo_text') }}</span>
            @endif
        </div>
        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Очередность:</label>
            <div class="col-sm-10">
            <input type="number" step="1" class="form-control" placeholder="Очередность" name="order" value="{{ old('order', 500) }}">
            </div>
            @if ($errors->has('order'))
                <span class="text-danger">{{ $errors->first('order') }}</span>
            @endif
        </div>
      <div class="form-group row mt-3">
        <div class="col-sm-offset-2 col-sm-1">
            <a href="{{route('admin.hubs.index')}}" class="btn btn-default">Отмена</a>
          </div>
        <div class="col-sm-offset-2 col-sm-1">
          <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
      </div>
    </form>
  </div>
@endsection
