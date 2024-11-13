@extends('admin.layout')
@section('content')
<div class="container mt-5">
    <h2>Редактирование объекта</h2>
    <form class="form-horizontal" method="POST" action="{{route('admin.hotels.edit', $hotels->id)}}" enctype="multipart/form-data" id="hotelForm">
        @csrf

        <location-selector :elements="{{json_encode($locations)}}" :selected="{{json_encode(old('location_id', $hotels->location_id))}}" :name="'location_id'"></location-selector>

        <hub-selector :elements="{{json_encode($hubs)}}" :selected="{{json_encode(old('hub_id', $hotels->hub_id))}}" :name="'hub_id'"></hub-selector>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Название:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Название" name="name" value="{{ old('name', $hotels->name) }}">
            </div>
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Title:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Title" name="title" value="{{ old('title', $hotels->title) }}">
            </div>
            @if ($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Description:</label>
            <div class="col-sm-10">
                <textarea name="description" class="form-control" placeholder="Description" value="{{ old('description', $hotels->description) }}" style="resize: both; max-width: 1006px; max-height: 200px"></textarea>
            </div>
            @if ($errors->has('description'))
                <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
        </div>



{{--        <tagsbox :data="{{ json_encode(['all' => $allTags, 'old' => $tags]) }}"></tagsbox>--}}

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Изображение:</label>
            <div class="ml-3 mr-3">
                <hotel-image :type="'hotel'" :data="{{json_encode( explode(',',old('imgs', implode(',', $imgs))))}}"></hotel-image>
            </div>
            @if ($errors->has('img'))
                <span class="text-danger">{{ $errors->first('img') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Координаты:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Координаты" name="coordinates" value="{{ old('coordinates', $hotels->coordinates) }}">
            </div>
            @if ($errors->has('coordinates'))
                <span class="text-danger">{{ $errors->first('coordinates') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Список преимуществ:</label>
            <div class="col-sm-10">
                <iconbox :elements="{{ json_encode($svgs) }}" :selected="{{ old('places', json_encode($places)) }}"></iconbox>
            </div>
            @if ($errors->has('places'))
                <span class="text-danger">{{ $errors->first('places') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Адрес:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Адрес" name="address" value="{{ old('address', $hotels->address) }}">
            </div>
            @if ($errors->has('address'))
                <span class="text-danger">{{ $errors->first('address') }}</span>
            @endif
        </div>

        {{-- <optionbox :data="{{json_encode($options)}}"></optionbox> --}}

        <tagsbox :lable="'Опции'" :data="{{ json_encode(['all' => $options['allOption'], 'old' => old('optionIds', $options['oldOption'])]) }}" :name="'optionIds[]'"></tagsbox>

        <tagsbox :data="{{ json_encode(['all' => $allTags, 'old' => old('tagsId', $hotels->tags->pluck('id')->toArray())]) }}" :name="'tagsId[]'"></tagsbox>

        <div class="form-group mt-3">
            <div class=" col-sm-10">
                <label for="floatingTextarea22">Описание над контактами:</label>
                <Froala :name="'seo_text'" class="form-control" :value="'{{ old('seo_text', $hotels->seo_text) }}'" :placeholder="'СЕО описание'"></Froala>
            </div>
            @if ($errors->has('seo_text'))
                <span class="text-danger">{{ $errors->first('seo_text') }}</span>
            @endif
        </div>

        <h3><label class="mt-3 ms-3 control-label">Контакты:</label></h3>

        <div class="form-group mt-3">
            <div class="col-sm-10">
                <label for="floatingTextarea22">Описание контактов:</label>
                <Froala :name="'contact_description'" class="form-control" :value="'{{ old('contact_description', $hotels->contact_description) }}'" :placeholder="'Описание контактов'"></Froala>
            </div>
            @if ($errors->has('contact_description'))
                <span class="text-danger">{{ $errors->first('contact_description') }}</span>
            @endif
        </div>

        <phone-input :value="'{{ old('phone', json_decode($hotels->number)) }}'"></phone-input>

        @if ($errors->has('phone'))
            <span class="text-danger">{{ $errors->first('phone') }}</span>
        @endif

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Почта:</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" placeholder="example@mail.ru" name="email"
                       value="{{ old('email', $hotels->email) }}">
            </div>
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Сайт:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="website.ru" name="website"
                       value="{{ old('website', $hotels->website) }}">
            </div>
            @if ($errors->has('website'))
                <span class="text-danger">{{ $errors->first('website') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Ссылка на бронь:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="website.ru" name="reservation"
                       value="{{ old('reservation', $hotels->reservation) }}">
            </div>
            @if ($errors->has('reservation'))
                <span class="text-danger">{{ $errors->first('reservation') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Доп. соцсети:</label>
            <div class="col-sm-10">
                <iconbox :elements="{{ json_encode($socialSvgs) }}" :name="'social'" :selected="{{ old('social', json_encode($social)) }}"></iconbox>
            </div>
            @if ($errors->has('coordinates'))
                <span class="text-danger">{{ $errors->first('coordinates') }}</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Цена(Рубли):</label>
            <div class="col-sm-10">
                <input type="number" step="1" min="1" class="form-control" placeholder="Цена" name="price" value="{{ old('price', $hotels->price) }}">
            </div>
            @if ($errors->has('price'))
                <span class="text-danger">{{ $errors->first('price') }}</span>
            @endif
        </div>


        <div class="form-group mt-5">
            <h5 class="control-label col-sm-2">Пункты:</h5>
            <div class="mt-4">
                <div class="form-group mt-2 ml-3">
                    <label for="views" class="me-1">Просмотры</label>
                    @if($hotels->views)
                        <input type="checkbox" id="views" name="views" checked>
                    @else
                        <input type="checkbox" id="views" name="views">
                    @endif
                </div>
                <div class="form-group mt-2 ml-3">
                    <label for="likes" class="me-1">Понравилось</label>
                    @if($hotels->likes)
                        <input type="checkbox" id="likes" name="likes" checked>
                    @else
                        <input type="checkbox" id="likes" name="likes">
                    @endif
                </div>
                <div class="form-group mt-2 ml-3">
                    <label for="comments" class="me-1">Комментарии</label>
                    @if($hotels->comments)
                        <input type="checkbox" id="comments" name="comments" checked>
                    @else
                        <input type="checkbox" id="comments" name="comments">
                    @endif
                </div>
            </div>

        </div>

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Очередность:</label>
            <div class="col-sm-10">
                <input type="number" step="1" class="form-control" placeholder="Очередность" name="order" value="{{ old('order', $hotels->order) }}">
            </div>
            @if ($errors->has('order'))
                <span class="text-danger">{{ $errors->first('order') }}</span>
            @endif
        </div>

{{--        <blocks3 :data="{{ json_encode($blocks) }}"></blocks3>--}}

        <div class="form-group mt-3">
            <label class="control-label col-sm-2">Дата окончания:</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" name="end_date" value="{{ old('end_date', $hotels->end_date ? \Carbon\Carbon::parse($hotels->end_date)->format('Y-m-d\TH:i') : '') }}">
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
