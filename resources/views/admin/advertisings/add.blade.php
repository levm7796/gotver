@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Создание пользовательской рекламы</h2>
        <form class="form-horizontal" method="POST" action="{{route('admin.advertisings.store')}}">
            @csrf
            <div class="form-group mt-3">
                <label class="control-label col-sm-12">Название:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Название" name="name" value="{{ old('name') }}">
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
                            <option value="{{$user->id}}" {{ $user->id == old('user_id') ? 'selected' : '' }}>{{ $user->name }}</option>
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
                            <option value="{{$hotel->id}}" {{ $hotel->id == old('hotel_id') ? 'selected' : '' }}>{{ $hotel->name }} | {{ optional($hotel->location)->name }} | {{ optional($hotel->hub)->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($errors->has('hotel_id'))
                    <span class="text-danger">{{ $errors->first('article_id') }}</span>
                @endif
            </div>


            <tagsbox :old="{{ old('news') }}" :data="{{ json_encode($news) }}" :name="'news[]'" :lable="'Дополнительно новости'"></tagsbox>
            @if ($errors->has('news'))
                <span class="text-danger">{{ $errors->first('news') }}</span>
            @endif

            <tagsbox :data="{{ json_encode($articles) }}" :name="'articles[]'" :lable="'Дополнительно статьи'"></tagsbox>
            @if ($errors->has('articles'))
                <span class="text-danger">{{ $errors->first('articles') }}</span>
            @endif



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
