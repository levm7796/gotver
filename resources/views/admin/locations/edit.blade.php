@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Редактирование локации</h2>
        <form class="form-horizontal" method="POST" action="{{ route('admin.locations.edit', $location->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Название:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Название" name="name"
                        value="{{ old('name', $location->name) }}">
                </div>
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <label class="control-label col-sm-3">Название "Путеводитель по ...":</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Назавание" name="putevoditel_po"
                        value="{{ old('putevoditel_po', $location->putevoditel_po) }}">
                </div>
                @if ($errors->has('putevoditel_po'))
                    <span class="text-danger">{{ $errors->first('putevoditel_po') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Изображение:</label>
                <div class="ml-3 mr-3">
                    <hotel-image :type="'location'" :data="{{json_encode($imgs)}}"></hotel-image>
                </div>
                @if ($errors->has('img'))
                    <span class="text-danger">{{ $errors->first('img') }}</span>
                @endif
            </div>

            <div class="form-row">
                <div class="form-group mt-3">
                    <label class="control-label col-sm-2" for="email">Иконка:</label>
                    <div class="col-sm-10">
                        <drop-down :elements="{{ json_encode($svgs) }}"
                            :selected="{{ json_encode(old('icon', $location->icon)) }}" :name="'icon'"></drop-down>
                        @if ($errors->has('icon'))
                            <span class="text-danger">{{ $errors->first('icon') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="control-label col-sm-2">Очередность:</label>
                    <div class="col-sm-10">
                        <input type="number" step="1" class="form-control" placeholder="Очередность" name="order"
                            value="{{ old('order', $location->order) }}">
                    </div>
                    @if ($errors->has('order'))
                        <span class="text-danger">{{ $errors->first('order') }}</span>
                    @endif
                </div>
            </div>

            <div class="form-group mt-3">
                <div class="form-floating col-sm-10">
                    <textarea name="seo_text" class="form-control" id="floatingTextarea2" style="height: 100px"> {{ old('seo_text', $location->seo_text) }}</textarea>
                    <label for="floatingTextarea2">Описание</label>
                </div>
                @if ($errors->has('seo_text'))
                    <span class="text-danger">{{ $errors->first('seo_text') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <div class="form-floating col-sm-10">
                    <textarea name="btn_text" class="form-control" id="" cols="90" rows="5" >{{ old('btn_text', $location->btn_text) }}</textarea>
                    <label for="floatingTextarea2">Текст кнопки селектора</label>
                </div>
                @if ($errors->has('btn_text'))
                    <span class="text-danger">{{ $errors->first('btn_text') }}</span>
                @endif
            </div>
            <h2 class="mt-5">Редактирование страницы локации</h2>


            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Title:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Title" name="title"
                        value="{{ old('title', optional($location->getContent())['title']) }}">
                </div>
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Description:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Description" name="description"
                        value="{{ old('description', optional($location->getContent())['description']) }}">
                </div>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>


            <h4 class="mt-2">Блоки:</h4>

            <div class="form-group mt-3">
                <label>H1</label>
                <div class=" col-sm-10">
                    <input type="text" name="h1" class="form-control" value="{{ old('h1', optional($location->getContent())['h1']) }}" placeholder="Заголовок">
                </div>
                @if ($errors->has('h1'))
                    <span class="text-danger">{{ $errors->first('h1') }}</span>
                @endif
            </div>

            <div class="ms-2">
                <div class="form-group mt-3">
                        <label>Заголовок блока Путешествия</label>
                    <div class=" col-sm-10">
                        <input type="text" name="titleTravel" class="form-control" value="{{ old('titleTravel', optional($location->getContent())['titleTravel']) }}" placeholder="Заголовок">
                    </div>
                    @if ($errors->has('titleTravel'))
                        <span class="text-danger">{{ $errors->first('titleTravel') }}</span>
                    @endif
                </div>

                <div class="form-group mt-3">
                        <label>Описание блока Путешествия</label>
                    <div class="form-floating col-sm-10">
                        <Froala :name="'descriptionTravel'" class="form-control" :value="'{{ old('title1', optional($location->getContent())['descriptionTravel']) }}'" :placeholder="'Описание'"></Froala>
                    </div>
                    @if ($errors->has('descriptionTravel'))
                        <span class="text-danger">{{ $errors->first('descriptionTravel') }}</span>
                    @endif
                </div>

                <div class="form-group mt-3">
                        <label>Заголовок блока Тэгов</label>
                    <div class=" col-sm-10">
                        <input name="titleTags" class="form-control" value="{{ old('titleTags', optional($location->getContent())['titleTags']) }}" placeholder="Заголовок">
                    </div>
                    @if ($errors->has('titleTags'))
                        <span class="text-danger">{{ $errors->first('titleTags') }}</span>
                    @endif
                </div>


                <div class="form-group mt-3">
                        <label>Описание блока Тэгов</label>
                    <div class="form-floating col-sm-10">
                        <Froala :name="'descriptionTags'" class="form-control" :value="'{{ old('descriptionTags', optional($location->getContent())['descriptionTags']) }}'" :placeholder="'Описание'"></Froala>
                    </div>
                    @if ($errors->has('descriptionTags'))
                        <span class="text-danger">{{ $errors->first('descriptionTags') }}</span>
                    @endif
                </div>

            </div>

            <tagsbox :data="{{ json_encode(['all' => $hubs, 'old' => old('hubs', optional($location->getContent())['hubs'])]) }}"
                     :lable="'Список хабовых в слайдэре'"
                     :name="'hubs[]'"
                     :hidden-data="1"
                ></tagsbox>



            <tagsbox :data="{{ json_encode(['all' => $tags, 'old' => old('additional_tags_add', optional($location->getContent())['additional_tags_add'])]) }}"
                :lable="'Добавить принудительно дополнительные тэги'"
                :name="'additional_tags_add[]'"
                :hidden-data="1"
           ></tagsbox>

           <tagsbox :data="{{ json_encode(['all' => $tags, 'old' => old('additional_tags_remove', optional($location->getContent())['additional_tags_remove'])]) }}"
                :lable="'Удалить принудительно дополнительные тэги'"
                :name="'additional_tags_remove[]'"
                :hidden-data="1"
            ></tagsbox>

            {{-- <div class="form-group mt-3">
                <label class="control-label col-sm-2">Статья(анонс) в конце:</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Права" name="article_id">
                        <option value="-1" {{ -1 == (old('article_id', optional($location->getContent())['article_id'])) ? 'selected' : '' }}>Вывод последней созданой</option>
                        <option value="0" {{ 0 == (old('article_id', optional($location->getContent())['article_id'])) ? 'selected' : '' }}>Не выводить</option>
                        <option disabled>----------</option>
                        @foreach($articles as $article)
                            <option value="{{$article->id}}" {{ $article->id == (old('article_id', optional($location->getContent())['article_id'])) ? 'selected' : '' }}>{{ $article->name }}</option>
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
                    <Froala :name="'article_text'" class="form-control" :value="'{{ old('article_text', optional($location->getContent())['article_text']) }}'" :placeholder="'Описание'"></Froala>
                </div>
                @if ($errors->has('article_text'))
                    <span class="text-danger">{{ $errors->first('article_text') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-12">Автоплей скрол популярных статей:</label>
                <div class="col-sm-10 form-check">
                    <input type="hidden" value="0" name="autoplay" checked>
                    <input type="checkbox" class="form-check-input" value="1" id="flexCheckDefault-autoplay" name="autoplay" @if(old('autoplay', optional($location->getContent())['autoplay']) == 1) checked @endif>
                    <label class="form-check-label" for="flexCheckDefault-autoplay">
                        Автоматически
                    </label>
                </div>
            </div>

            <h2 class="mt-5">Редактирование списка страниц в меню</h2>
            <menu-links :old="{{ optional($location->getContent())['menu_links'] }}" :name="'menu_links'" :title="'Группы'"></menu-links>

            <div class="form-group row mt-3">
                <div class="col-sm-offset-2 col-sm-1">
                    <a href="{{ route('admin.locations.index') }}" class="btn btn-default">Отмена</a>
                </div>
                <div class="col-sm-offset-2 col-sm-1">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
