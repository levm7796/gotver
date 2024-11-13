@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h2>Редактирование тэга</h2>
    <form class="form-horizontal" method="POST" action="{{route('admin.tags.edit', $tag->id)}}">
        @csrf
        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Название:</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" placeholder="Название" name="name" value="{{ old('name', $tag->name) }}">
            </div>
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class="form-group mt-3">
            <label class="control-label ">Тип:</label>
            <div class="col-sm-10">
                <select id="type" class="form-control" name="type" value="{{ old('type', $tag->type) }}" disabled>
                    <option value="0">Локация</option>
                    <option value="1">Новость</option>
                    <option value="2" disabled>-</option>
                </select>
                <input type="hidden" name="type" value="{{ old('type', $tag->type) }}">
            </div>
            @if ($errors->has('type'))
                <span class="text-danger">{{ $errors->first('type') }}</span>
            @endif
        </div>
{{--        <div class="form-group mt-3">--}}
{{--            <label class="control-label col-sm-2" for="email">Иконка:</label>--}}
{{--            <div class="col-sm-10">--}}
{{--                <drop-down :elements="{{ json_encode($svgs) }}" :selected="{{ json_encode(old('icon', $location->icon)) }}" :name="'icon'"></drop-down>--}}
{{--                @if ($errors->has('icon'))--}}
{{--                    <span class="text-danger">{{ $errors->first('icon') }}</span>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="form-group mt-3">--}}
{{--            <label class="control-label col-sm-2">Описание:</label>--}}
{{--            <div class="form-floating col-sm-10">--}}
{{--                <textarea name="description"  class="form-control" id="floatingTextarea2" style="height: 100px"> {{ old('description', $location->description) }}</textarea>--}}
{{--                <label for="floatingTextarea2">Описание</label>--}}
{{--              </div>--}}
{{--            @if ($errors->has('description'))--}}
{{--                <span class="text-danger">{{ $errors->first('description') }}</span>--}}
{{--            @endif--}}
{{--        </div>--}}
        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Очередность:</label>
            <div class="col-sm-10">
            <input type="number" step="1" class="form-control" placeholder="Очередность" name="order" value="{{ old('order', $tag->order) }}">
            </div>
            @if ($errors->has('order'))
                <span class="text-danger">{{ $errors->first('order') }}</span>
            @endif
        </div>

        <h2 class="mt-5">Редактирование страницы тэга</h2>
        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Title:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Title" name="title"
                    value="{{ old('title', optional($tag->getContent())['title']) }}">
            </div>
            @if ($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Description:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Description" name="description"
                    value="{{ old('description', optional($tag->getContent())['description']) }}">
            </div>
            @if ($errors->has('description'))
                <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
        </div>

        {{-- <div class="form-group mt-3">
            <label class="control-label col-sm-2">Статья в конце:</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Права" name="article_id">
                    <option value="-1" {{ -1 == (old('article_id', optional($tag->getContent())['article_id'])) ? 'selected' : '' }}>Выводить последний созданый</option>
                    <option value="0" {{ 0 == (old('article_id', optional($tag->getContent())['article_id'])) ? 'selected' : '' }}>Не выводить</option>
                    <option disabled>----------</option>
                    @foreach($articles as $article)
                        <option value="{{$article->id}}" {{ $article->id == (old('article_id', optional($tag->getContent())['article_id'])) ? 'selected' : '' }}>{{ $article->name }}</option>
                    @endforeach
                </select>
            </div>
            @if ($errors->has('article_id'))
                <span class="text-danger">{{ $errors->first('article_id') }}</span>
            @endif
        </div> --}}

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Статья в конце:</label>
            <div class="col-sm-10">
                <Froala :name="'article_text'" class="form-control" :value="'{{ old('article_text', optional($tag->getContent())['article_text']) }}'" :placeholder="'Описание'"></Froala>
            </div>
            @if ($errors->has('article_text'))
                <span class="text-danger">{{ $errors->first('article_text') }}</span>
            @endif
        </div>

        <tagsbox :data="{{ json_encode(['all' => $tags, 'old' => old('additional_tags_add', optional($tag->getContent())['additional_tags_add'])]) }}"
            :lable="'Добавить принудительно дополнительные тэги'"
            :name="'additional_tags_add[]'"
       ></tagsbox>

       <tagsbox :data="{{ json_encode(['all' => $tags, 'old' => old('additional_tags_remove', optional($tag->getContent())['additional_tags_remove'])]) }}"
            :lable="'Удалить принудительно дополнительные тэги'"
            :name="'additional_tags_remove[]'"
        ></tagsbox>

      <div class="form-group row mt-3">
        <div class="col-sm-offset-2 col-sm-1">
            <a href="{{route('admin.tags.index')}}" class="btn btn-default">Отмена</a>
          </div>
        <div class="col-sm-offset-2 col-sm-1">
          <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
      </div>
    </form>
  </div>
@endsection
