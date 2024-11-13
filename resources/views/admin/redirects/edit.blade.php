@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Редиктирование редиректа</h2>
        <form class="form-horizontal" method="POST" action="{{route('admin.redirects.edit', $redirect->id )}}">
            @csrf
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Откуда:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="/location/*" name="from" value="{{ old('from', $redirect->from) }}">
                </div>
                @if ($errors->has('from'))
                    <span class="text-danger">{{ $errors->first('from') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Куда:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="/location/1" name="to" value="{{ old('to', $redirect->to) }}">
                </div>
                @if ($errors->has('to'))
                    <span class="text-danger">{{ $errors->first('to') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <label class="control-label">Активность</label>
                <div class="col-sm-10">
                    <select id="type" class="form-control" name="active">
                        <option value="1" @if(old('active', $redirect->active) == 1) selected @endif>Активен</option>
                        <option value="0" @if(old('active', $redirect->active) == 0) selected @endif>Выключен</option>
                    </select>
                </div>
                @if ($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Код ответа:</label>
                <div class="col-sm-10">
                    <input type="number" min="0" step="1" class="form-control" placeholder="301" name="code" value="{{ old('code', $redirect->code) }}">
                </div>
                @if ($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Очередность:</label>
                <div class="col-sm-10">
                    <input type="number" step="1" class="form-control" placeholder="Очередность" name="order" value="{{ old('order', $redirect->order) }}">
                </div>
                @if ($errors->has('order'))
                    <span class="text-danger">{{ $errors->first('order') }}</span>
                @endif
            </div>

            <div class="form-group row mt-3">
                <div class="col-sm-offset-2 col-sm-1">
                    <a href="{{route('admin.redirects.index')}}" class="btn btn-default">Отмена</a>
                </div>
                <div class="col-sm-offset-2 col-sm-1">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
