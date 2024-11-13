@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Обшие настроки верстки</h2>
        <form class="form-horizontal" method="POST" >
            @csrf
            <h3>Социальные ссылки</h3>
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Ссылка дзен:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Ссылка дзен" name="dzen"
                        value="{{ old('dzen', optional($settings)['dzen']) }}">
                </div>
                @if ($errors->has('dzen'))
                    <span class="text-danger">{{ $errors->first('dzen') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Ссылка VK:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Ссылка VK" name="vk"
                        value="{{ old('vk', optional($settings)['vk']) }}">
                </div>
                @if ($errors->has('vk'))
                    <span class="text-danger">{{ $errors->first('vk') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Ссылка TG:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Ссылка TG" name="tg"
                        value="{{ old('tg', optional($settings)['tg']) }}">
                </div>
                @if ($errors->has('tg'))
                    <span class="text-danger">{{ $errors->first('tg') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Ссылка OK:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Ссылка OK" name="ok"
                        value="{{ old('ok', optional($settings)['ok']) }}">
                </div>
                @if ($errors->has('ok'))
                    <span class="text-danger">{{ $errors->first('ok') }}</span>
                @endif
            </div>
            <link-generator :old=" {{ old('footer_links', optional($settings)['footer_links']) }}" :title="'Ссылки в футере'" :name="'footer_links'"></link-generator>

            <h3>Дефолтные пункты меню</h3>

            <link-generator :old=" {{ old('roads', optional($settings)['roads']) }}" :title="'Направления'" :name="'roads'"></link-generator>

            <link-generator :old=" {{ old('users', optional($settings)['users']) }}" :title="'Пользователям'" :name="'users'" :svgs="{{ json_encode($svgs) }}" :withico="true" ></link-generator>

            <h3 class="mt-2">Блоки</h3>

            <tagsbox :data="{{ json_encode(['all' => $hubs, 'old' => old('main_hubs', optional($settings)['main_hubs'])]) }}"
                :lable="'Список хабовых популярные направления(на главной)'"
                :name="'main_hubs[]'"
                :hidden-data="1"
           ></tagsbox>

            <div class="form-group mt-3">
                <label class="control-label col-sm-12">Популярные направление туризма:</label>
                <div class="col-sm-10">
{{--                    <textarea type="text" class="form-control editor" placeholder="Описание" name="touring"--}}
{{--                              value="{{ old('touring', $blocks->touring) }}"></textarea>--}}
                    <Froala :name="'touring'" :value="'{{ old('touring', optional($settings)['touring']) }}'" :placeholder="'Описание'"></Froala>
                </div>
                @if ($errors->has('touring'))
                    <span class="text-danger">{{ $errors->first('touring') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-12">Популярные статьи:</label>
                <div class="col-sm-10">
{{--                    <textarea type="text" class="editor" placeholder="Описание" name="articles"--}}
{{--                           value="{{ old('articles', $blocks->article) }}"--}}
{{--                    ></textarea>--}}
                    <Froala :name="'article'" :value="'{{old('article', optional($settings)['article']) }}'" :placeholder="'Описание'"></Froala>
                </div>
                @if ($errors->has('articles'))
                    <span class="text-danger">{{ $errors->first('articles') }}</span>
                @endif
            </div>


            <div class="form-group row mt-3">
                <div class="col-sm-offset-2 col-sm-1">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>

        </form>
    </div>
@endsection
