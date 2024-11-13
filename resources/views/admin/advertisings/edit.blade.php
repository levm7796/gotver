@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h2>Редактирование пользовательской рекламы</h2>
    <form class="form-horizontal" method="POST" action="{{route('admin.advertisings.edit', $advertising->id)}}">
        @csrf
        <div class="form-group mt-3">
            <label class="control-label col-sm-12">Название:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Название" name="name" value="{{ old('name', $advertising->name) }}">
            </div>
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Пользователь:</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Права" name="user_id">
                    <option disabled>----------</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}" {{ $user->id == old('user_id', $advertising->user_id) ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('user_id'))
                <span class="text-danger">{{ $errors->first('article_id') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Страница объекта:</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Права" name="hotel_id">
                    <option disabled>----------</option>
                    @foreach($hotels as $hotel)
                        <option value="{{$hotel->id}}" {{ $hotel->id == old('hotel_id', $advertising->hotel_id) ? 'selected' : '' }}>{{ $hotel->name }} | {{ optional($hotel->location)->name }} | {{ optional($hotel->hub)->name }} | До {{ $hotel->end_date ? $hotel->end_date : '-' }}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('hotel_id'))
                <span class="text-danger">{{ $errors->first('article_id') }}</span>
            @endif
        </div>


        <tagsbox :data="{{ json_encode(['all' => $news, 'old' => old('news', explode(',', $advertising->news))]) }}" :name="'news[]'" :lable="'Дополнительно новости'"></tagsbox>
        @if ($errors->has('news'))
            <span class="text-danger">{{ $errors->first('news') }}</span>
        @endif

        <tagsbox :data="{{ json_encode(['all' => $articles, 'old' => old('articles', explode(',', $advertising->articles))]) }}" :name="'articles[]'" :lable="'Дополнительно статьи'"></tagsbox>
        @if ($errors->has('articles'))
            <span class="text-danger">{{ $errors->first('articles') }}</span>
        @endif

        {{--<div class="form-group mt-3">
            <label class="control-label col-sm-2">Дата создания:</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" name="created_at" value="{{ old('created_at', $advertising->created_at ? $advertising->created_at->format('Y-m-d\TH:i') : '') }}">
            </div>
            @if ($errors->has('created_at'))
                <span class="text-danger">{{ $errors->first('created_at') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Дата окончания:</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" name="end_date" value="{{ old('end_date', $advertising->end_date ? \Carbon\Carbon::parse($advertising->end_date)->format('Y-m-d\TH:i') : '') }}">
            </div>
            @if ($errors->has('end_date'))
                <span class="text-danger">{{ $errors->first('end_date') }}</span>
            @endif
        </div>--}}

        <div class="form-group row mt-3">
            <div class="col-sm-offset-2 col-sm-1">
                <a href="{{route('admin.advertisings.index')}}" class="btn btn-default">Отмена</a>
            </div>
            <div class="col-sm-offset-2 col-sm-1">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </form>
  </div>
@endsection
