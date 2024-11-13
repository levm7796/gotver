@extends('admin.layout')
@section('content')
{{--    <script src=".AdminLTE-3.0.5/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>--}}
    <div class="container mt-5">
        <h2>Создание новости</h2>
        <form class="form-horizontal" method="POST" action="{{route('admin.news.store')}}" enctype="multipart/form-data" id="newsForm">
            @csrf

            <location-selector :elements="{{json_encode($locations)}}" :selected="{{json_encode(old('location_id', null))}}" :name="'location_id'"></location-selector>
            @if ($errors->has('location_id'))
                <span class="text-danger">{{ $errors->first('location_id') }}</span>
            @endif
            <hub-selector :elements="{{json_encode($hubs)}}" :selected="{{json_encode(old('hub_id', null))}}" :name="'hub_id'"></hub-selector>
            @if ($errors->has('hub_id'))
                <span class="text-danger">{{ $errors->first('hub_id') }}</span>
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
                <label class="control-label col-sm-2">Title:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Title" name="title" value="{{ old('title') }}">
                </div>
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Description:</label>
                <div class="col-sm-10">
                   <textarea type="text" class="form-control summernote" placeholder="Description" name="description" value="{{ old('description') }}"></textarea>
                    {{-- <textarea class="editor" name="description"></textarea> --}}
                </div>
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <tagsbox :data="{{ json_encode(['all' => $tags, 'old' => old('tagsId')]) }}" :name="'tagsId[]'"></tagsbox>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Изображение:</label>
                <div class="ml-3 mr-3">
                    <new-image :max="1" :x="870" :y="500" :name="'img'" :data="{{ json_encode([old('img')]) }}" type="1" :andthumb="true" :minisecond="true"
                                :x2="424" :y2="356" :name2="'thumbImg'" :data2="{{ json_encode([old('imgthumb')]) }} "
                        ></new-image>
                </div>
                @if ($errors->has('img'))
                    <span class="text-danger">{{ $errors->first('img') }}</span>
                @endif
            </div>

{{--            <div class="form-group mt-3">--}}
{{--                <label class="control-label col-sm-2">Автор:</label>--}}
{{--                <div class="col-sm-10">--}}
{{--                    <input type="text" class="form-control" placeholder="Имя фамилия" name="author" value="{{ old('author') }}">--}}
{{--                </div>--}}
{{--                @if ($errors->has('author'))--}}
{{--                    <span class="text-danger">{{ $errors->first('author') }}</span>--}}
{{--                @endif--}}
{{--            </div>--}}

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Координаты:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Координаты" name="coordinates" value="{{ old('coordinates') }}">
                </div>
                @if ($errors->has('coordinates'))
                    <span class="text-danger">{{ $errors->first('coordinates') }}</span>
                @endif
            </div>
            <div class="form-group mt-5">
                <h5 class="control-label col-sm-2">Пункты:</h5>
                <div class="mt-4">
                    <div class="form-group mt-2 ml-3">
                        <label for="views" class="me-1">Просмотры</label>
                        <input type="hidden" value="0" name="views" checked>
                        <input type="checkbox" value="1" name="views" @if(old('views') == 1)checked @endif>
                    </div>
                    <div class="form-group mt-2 ml-3">
                        <label for="likes" class="me-1">Понравилось</label>
                        <input type="hidden" value="0" name="likes" checked>
                        <input type="checkbox" value="1" name="likes" @if(old('likes') == 1)checked @endif>
                    </div>
                    <div class="form-group mt-2 ml-3">
                        <label for="comments" class="me-1">Комментарии</label>
                        <input type="hidden" value="0" name="comments" checked>
                        <input type="checkbox" value="1" name="comments" @if(old('comments') == 1)checked @endif>
                    </div>
                </div>
            </div>

            <div class="form-group mt-3" style="display: none;">
                <label class="control-label col-sm-2">Очередность:</label>
                <div class="col-sm-10">
                    <input type="number" step="1" class="form-control" placeholder="Очередность" name="order" value="{{ old('order', 500) }}">
                </div>
                @if ($errors->has('order'))
                    <span class="text-danger">{{ $errors->first('order') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Подпись:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Время чтения: 8 минут" name="signature" value="{{ old('signature', 'Время чтения: 8 минут') }}">
                </div>
                @if ($errors->has('signature'))
                    <span class="text-danger">{{ $errors->first('signature') }}</span>
                @endif
            </div>

            <news-blocks :data="{{ old('blocks') }}"></news-blocks>
            {{-- <blocks3></blocks3> --}}

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Дата окончания:</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control" name="end_date" value="{{ old('end_date') }}">
                </div>
                @if ($errors->has('end_date'))
                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                @endif
            </div>

            <div class="form-group row mt-3">
                <div class="col-sm-offset-2 col-sm-1">
                    <a href="{{route('admin.news.index')}}" class="btn btn-default">Отмена</a>
                </div>
                <div class="col-sm-offset-2 col-sm-1">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>

@endsection
