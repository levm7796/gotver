@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h2>Редактирование серии истории</h2>
    <form class="form-horizontal" method="POST" action="{{route('admin.histories.edit', $history->id)}}">
        @csrf
        <div class="form-group mt-3">
            <label class="control-label col-sm-12">Шаблон:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="location/*" name="pattern" value="{{ old('pattern', $history->pattern) }}">
            </div>
            @if ($errors->has('pattern'))
                <span class="text-danger">{{ $errors->first('pattern') }}</span>
            @endif
        </div>

        <history :old="{{ old('content',($history->content)) }}" :name="'content'" :title="'Истории'"></history>

        <div class="form-group mt-3">
            <label class="control-label col-sm-12">Очередность:</label>
            <div class="col-sm-10">
            <input type="number" step="1" class="form-control" placeholder="Очередность" name="order" value="{{ old('order', $history->order) }}">
            </div>
            @if ($errors->has('order'))
                <span class="text-danger">{{ $errors->first('order') }}</span>
            @endif
        </div>
      <div class="form-group row mt-3">
        <div class="col-sm-offset-2 col-sm-1">
            <a href="{{route('admin.histories.index')}}" class="btn btn-default">Отмена</a>
          </div>
        <div class="col-sm-offset-2 col-sm-1">
          <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
      </div>
    </form>
  </div>
@endsection
