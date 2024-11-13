@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h2>Редактирование коментария</h2>
    <form class="form-horizontal" method="POST" action="{{route('admin.comments.edit', $comment->id)}}">
        @csrf
        <div class="form-group mt-3">
            <label class="control-label col-sm-12">Пользователь:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" disabled value="{{ $comment->user->name }}">
            </div>
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-12">Пользователь:</label>
            <div class="col-sm-10">
                <textarea type="text" class="form-control" name="message" value="{{ $comment->message }}"></textarea>
            </div>
            @if ($errors->has('message'))
                <span class="text-danger">{{ $errors->first('message') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label">Активность</label>
            <div class="col-sm-10">
                <select id="type" class="form-control" name="cheked">
                    <option value="1" @if(old('cheked', $comment->cheked) == 1) selected @endif>Активен</option>
                    <option value="0" @if(old('cheked', $comment->cheked) == 0) selected @endif>Выключен</option>
                </select>
            </div>
            @if ($errors->has('cheked'))
                <span class="text-danger">{{ $errors->first('cheked') }}</span>
            @endif
        </div>

      <div class="form-group row mt-3">
        <div class="col-sm-offset-2 col-sm-1">
            <a href="{{route('admin.comments.index')}}" class="btn btn-default">Отмена</a>
          </div>
        <div class="col-sm-offset-2 col-sm-1">
          <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
      </div>
    </form>
  </div>
@endsection
