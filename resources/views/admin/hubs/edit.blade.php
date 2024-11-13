@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Редактирование хабовой</h2>
        <form class="form-horizontal" method="POST" action="{{ route('admin.hubs.edit', $hub->id) }}" enctype="multipart/form-data">
            @csrf

            <location-selector :elements="{{ json_encode($locations) }}"
                :selected="{{ json_encode(old('location_id', $hub->location_id)) }}"
                :name="'location_id'"></location-selector>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Название:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Название" name="name"
                        value="{{ old('name', $hub->name) }}">
                </div>
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <label class="control-label col-sm-2" for="email">Иконка:</label>
                <div class="col-sm-10">
                    <drop-down :elements="{{ json_encode($svgs) }}" :selected="{{ json_encode(old('icon', $hub->icon)) }}"
                        :name="'icon'"></drop-down>
                    @if ($errors->has('icon'))
                        <span class="text-danger">{{ $errors->first('icon') }}</span>
                    @endif
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-12">Описание:</label>
                <div class="form-floating col-sm-10">
                    <Froala :name="'seo_text'" class="form-control" id="floatingTextarea2" :value="'@if(!is_null(old('seo_text'))) {{old('seo_text')}} @else {{$hub->seo_text}} @endif'"></Froala>
{{--                    <label for="floatingTextarea2">Описание</label>--}}

                </div>
                @if ($errors->has('seo_text'))
                    <span class="text-danger">{{ $errors->first('seo_text') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Очередность:</label>
                <div class="col-sm-10">
                    <input type="number" step="1" class="form-control" placeholder="Очередность" name="order"
                        value="{{ old('order', $hub->order) }}">
                </div>
                @if ($errors->has('order'))
                    <span class="text-danger">{{ $errors->first('order') }}</span>
                @endif
            </div>

            <h2 class="mt-5">Редактирование хабовой страницы</h2>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Title:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Title" name="title"
                        value="{{ old('title', optional($hub->getContent())['title']) }}">
                </div>
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Description:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Description" name="description"
                        value="{{ old('description', optional($hub->getContent())['description']) }}">
                </div>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>

            <h4 class="mt-2">Блоки:</h4>
            <div class="ms-2">
                <div class="form-group mt-3">
                    <label>H1</label>
                    <div class=" col-sm-10">
                        <input name="h1" class="form-control" value="{{ old('h1', optional($hub->getContent())['h1']) }}" placeholder="Заголовок">
                    </div>
                    @if ($errors->has('h1'))
                        <span class="text-danger">{{ $errors->first('h1') }}</span>
                    @endif
                </div>
            </div>
            <div class="ms-2">
                <div class="form-group mt-3">
                    <label>Заголовок блока Тэгов</label>
                    <div class=" col-sm-10">
                        <input name="titleTags" class="form-control" value="{{ old('titleTags', optional($hub->getContent())['titleTags']) }}" placeholder="Заголовок">
                    </div>
                    @if ($errors->has('titleTags'))
                        <span class="text-danger">{{ $errors->first('titleTags') }}</span>
                    @endif
                </div>
            </div>
            <div class="ms-2">
                <div class="form-group mt-3">
                    <label>Заголовок блока Смотреть также</label>
                    <div class=" col-sm-10">
                        <input name="titleAlso" class="form-control" value="{{ old('titleAlso', optional($hub->getContent())['titleAlso']) }}" placeholder="Заголовок">
                    </div>
                    @if ($errors->has('titleAlso'))
                        <span class="text-danger">{{ $errors->first('titleAlso') }}</span>
                    @endif
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-12">Изображение для главной(популярные направления):</label>
                <div class="ml-3 mr-3">
                    <new-image :max="1" :x="216" :y="320" :name="'img'" :data="{{ json_encode([old('img', $hub->img())]) }}" type="1"
                    ></new-image>
                </div>
                @if ($errors->has('img'))
                    <span class="text-danger">{{ $errors->first('img') }}</span>
                @endif
            </div>

            <tagsbox :data="{{ json_encode(['all' => $tags, 'old' => old('additional_tags_add', optional($hub->getContent())['additional_tags_add'])]) }}"
                :lable="'Добавить принудительно дополнительные тэги'"
                :name="'additional_tags_add[]'"
           ></tagsbox>

           <tagsbox :data="{{ json_encode(['all' => $tags, 'old' => old('additional_tags_remove', optional($hub->getContent())['additional_tags_remove'])]) }}"
                :lable="'Удалить принудительно дополнительные тэги'"
                :name="'additional_tags_remove[]'"
            ></tagsbox>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Блоки на странице:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="block_logic" id="bl0" value="0" checked>
                    <label class="form-check-label" for="bl0">Обычное отоброжение блоков</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="block_logic" id="bl1" value="1" @if(old('block_logic', optional($hub->getContent())['block_logic']) == 1)checked @endif>
                    <label class="form-check-label" for="bl1">Поменять карточки и статьи местами</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="block_logic" id="bl2" value="2" @if(old('block_logic', optional($hub->getContent())['block_logic']) == 2)checked @endif>
                    <label class="form-check-label" for="bl2">Заменить карточки статьями</label>
                  </div>
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Статья в конце:</label>
                <div class="col-sm-10">
                    <Froala :name="'article_text'" class="form-control" :value="'{{ old('article_text', optional($hub->getContent())['article_text']) }}'" :placeholder="'Описание'"></Froala>
                </div>
                @if ($errors->has('article_text'))
                    <span class="text-danger">{{ $errors->first('article_text') }}</span>
                @endif
            </div>

            {{-- <div class="form-group mt-3">
                <label class="control-label col-sm-2">Статья в конце:</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Права" name="article_id">
                        <option value="-1" {{ -1 == (old('article_id', optional($hub->getContent())['article_id'])) ? 'selected' : '' }}>Выводить последний созданый</option>
                        <option value="0" {{ 0 == (old('article_id', optional($hub->getContent())['article_id'])) ? 'selected' : '' }}>Не выводить</option>
                        <option disabled>----------</option>
                        @foreach($articles as $article)
                            <option value="{{$article->id}}" {{ $article->id == (old('article_id', optional($hub->getContent())['article_id'])) ? 'selected' : '' }}>{{ $article->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($errors->has('article_id'))
                    <span class="text-danger">{{ $errors->first('article_id') }}</span>
                @endif
            </div> --}}

            <div class="form-group row mt-3">
                <div class="col-sm-offset-2 col-sm-1">
                    <a href="{{ route('admin.hubs.index') }}" class="btn btn-default">Отмена</a>
                </div>
                <div class="col-sm-offset-2 col-sm-1">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
