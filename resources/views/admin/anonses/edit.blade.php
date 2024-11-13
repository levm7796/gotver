@extends('admin.layout')
@section('content')
<div class="container mt-5">
{{--    @foreach($blocks as $block)--}}
{{--        <h1>{{$block['blockName']}}</h1>--}}
{{--    @endforeach--}}
{{--    @foreach($tags as $tag)--}}
{{--        <h1>{{$tag['name']}}</h1>--}}
{{--    @endforeach--}}
{{--    <h1>{{$news['id']}}</h1>--}}
{{--    <h1>{{$tags}}</h1>--}}
{{--    <h1>{{$blocks}}</h1>--}}
    <h2>Редактирование статьи</h2>
    <form class="form-horizontal" method="POST" action="{{route('admin.anonses.edit', $news->id)}}" enctype="multipart/form-data" id="newsForm">
        @csrf

        <location-selector :elements="{{json_encode($locations)}}" :selected="{{json_encode(old('location_id', $news->location_id))}}" :name="'location_id'"></location-selector>

        <hub-selector :elements="{{json_encode($hubs)}}" :selected="{{json_encode(old('hub_id', $news->hub_id))}}" :name="'hub_id'"></hub-selector>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Название:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Название" name="name" value="{{ old('name', $news->name) }}">
            </div>
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Title:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Название" name="title" value="{{ old('title', $news->title) }}">
            </div>
            @if ($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Description:</label>
            <div class="col-sm-10">
               <textarea type="text" class="form-control summernote" placeholder="Название" name="description" value="{{ old('description', $news->description) }}"></textarea>
                {{-- <textarea class="editor" name="description" v-html="'{{$news->description}}'"></textarea> --}}
            </div>
            @if ($errors->has('description'))
                <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
        </div>

        <tagsbox :data="{{ json_encode(['all' => $allTags, 'old' => old('tagsId', $news->tags->pluck('id')->toArray())]) }}" :name="'tagsId[]'"></tagsbox>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Изображение:</label>
            <div class="ml-3 mr-3">
                <new-image :max="1" :x="870" :y="500" :name="'img'" :data="{{ json_encode([old('img', $news->img)]) }}" type="1" :andthumb="true" :minisecond="true"
                                :x2="424" :y2="356" :name2="'thumbImg'" :data2="{{ json_encode([old('imgthumb', $news->thumbImg)]) }} "
                        ></new-image>
            </div>
            @if ($errors->has('img'))
                <span class="text-danger">{{ $errors->first('img') }}</span>
            @endif
        </div>

{{--        <div class="form-group mt-3">--}}
{{--            <label class="control-label col-sm-2">Автор:</label>--}}
{{--            <div class="col-sm-10">--}}
{{--                <input type="text" class="form-control" placeholder="Имя фамилия" name="author" value="{{ old('author', $news->author) }}">--}}
{{--            </div>--}}
{{--            @if ($errors->has('author'))--}}
{{--                <span class="text-danger">{{ $errors->first('author', $news->author) }}</span>--}}
{{--            @endif--}}
{{--        </div>--}}

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Координаты:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Координаты" name="coordinates" value="{{ old('coordinates', $news->coordinates) }}">
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
                    <input type="hidden" value="0" id="views" name="views" checked>
                    <input type="checkbox" value="1" id="views" name="views"  @if(old('views', $news->views))checked @endif>
                </div>
                <div class="form-group mt-2 ml-3">
                    <label for="likes" class="me-1">Понравилось</label>
                    <input type="hidden" value="0" id="likes" name="likes" checked>
                    <input type="checkbox" value="1" id="likes" name="likes" @if(old('likes', $news->likes))checked @endif>
                </div>
                <div class="form-group mt-2 ml-3">
                    <label for="comments" class="me-1">Комментарии</label>
                    <input type="hidden" value="0" id="comments" name="comments" checked>
                    <input type="checkbox" value="1" id="comments" name="comments" @if(old('comments', $news->comments))checked @endif>
                </div>
            </div>
        </div>

        <div class="form-group mt-3" style="display:none">
            <label class="control-label col-sm-2">Очередность:</label>
            <div class="col-sm-10">
                <input type="number" step="1" class="form-control" placeholder="Очередность" name="order" value="{{ old('order', $news->order) }}">
            </div>
            @if ($errors->has('order'))
                <span class="text-danger">{{ $errors->first('order') }}</span>
            @endif
        </div>

        {{-- <div class="form-group mt-3">
            <label class="control-label col-sm-2">Подпись:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Время чтения: 8 минут" name="signature" value="{{ old('signature', $news->signature) }}">
            </div>
            @if ($errors->has('signature'))
                <span class="text-danger">{{ $errors->first('signature') }}</span>
            @endif
        </div> --}}

        <news-blocks :data="{{ old('blocks', json_encode($blocks)) }}"></news-blocks>
        {{-- <blocks3 :data="{{ json_encode($blocks) }}"></blocks3> --}}

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Дата создания:</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" name="created_at" value="{{ old('created_at', $news->created_at ? $news->created_at->format('Y-m-d\TH:i') : '') }}">
            </div>
            @if ($errors->has('created_at'))
                <span class="text-danger">{{ $errors->first('created_at') }}</span>
            @endif
        </div>

        {{-- <div class="form-group mt-3">
            <label class="control-label col-sm-2">Дата окончания:</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" name="end_date" value="{{ old('end_date', $news->end_date ? \Carbon\Carbon::parse($news->end_date)->format('Y-m-d\TH:i') : '') }}">
            </div>
            @if ($errors->has('end_date'))
                <span class="text-danger">{{ $errors->first('end_date') }}</span>
            @endif
        </div> --}}

        <div class="form-group row mt-3">
            <div class="col-sm-offset-2 col-sm-1">
                <a href="{{route('admin.anonses.index')}}" class="btn btn-default">Отмена</a>
            </div>
            <div class="col-sm-offset-2 col-sm-1">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </form>
  </div>
@endsection
<script>
    let counter = 0

    function addBlock() {
        counter++
    }

    function getCounter() {
        return counter
    }
</script>
