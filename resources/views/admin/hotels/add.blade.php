@extends('admin.layout')
@section('content')
{{--    <script src=".AdminLTE-3.0.5/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>--}}
    <div class="container mt-5">
        <h2>Создание объекта</h2>
        <form class="form-horizontal" method="POST" action="{{route('admin.hotels.store')}}" enctype="multipart/form-data" id="hotelForm">
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
                <div class="form-floating col-sm-10">
                    <textarea id="floatingTextarea22" class="form-control" name="description" style="resize: both; max-width: 1006px; max-height: 200px" value="{{ old('description') }}"></textarea>
                    <label for="floatingTextarea22">Description:</label>
                </div>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>

{{--            <tagsbox :data="{{ $tags }}"></tagsbox>--}}

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Изображение:</label>
                <div class="ml-3 mr-3">
                    <hotel-image :type="'hotel'" :data="{{ json_encode(explode(',',old('imgs', ''))) }}"></hotel-image>
                </div>
                @if ($errors->has('imgs'))
                    <span class="text-danger">{{ $errors->first('imgs') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Координаты:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Координаты" name="coordinates" value="{{ old('coordinates') }}">
                </div>
                @if ($errors->has('coordinates'))
                    <span class="text-danger">{{ $errors->first('coordinates') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Адрес:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Адрес" name="address" value="{{ old('address') }}">
                </div>
                @if ($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Список преимуществ:</label>
                <div class="col-sm-10">
                    <iconbox :elements="{{ json_encode($svgs) }}" :selected="{{ old('places', json_encode([])) }}"></iconbox>
                </div>
                @if ($errors->has('places'))
                    <span class="text-danger">{{ $errors->first('places') }}</span>
                @endif
                {{-- @if ($errors->has('coordinates'))
                    <span class="text-danger">{{ $errors->first('coordinates') }}</span>
                    <span class="text-danger">{{ $errors->first('coordinates') }}</span>
                @endif --}}
            </div>

            {{-- <optionbox :data="{{json_encode($options)}}"></optionbox> --}}
            <tagsbox :data="{{ json_encode(['all' => $options, 'old' => old('optionIds', [])]) }}" :lable="'Опции:'" :name="'optionIds[]'"></tagsbox>
            @if ($errors->has('optionIds'))
                <span class="text-danger">{{ $errors->first('optionIds') }}</span>
            @endif

            <tagsbox :data="{{ json_encode(['all' => $tags, 'old' => old('tagsId', [])]) }}" :name="'tagsId[]'"></tagsbox>
            @if ($errors->has('tagsId'))
                <span class="text-danger">{{ $errors->first('tagsId') }}</span>
            @endif

            <div class="form-group mt-3">
                <div class=" col-sm-10">
                    <label for="floatingTextarea22">Описание над контактами:</label>
                    <Froala :name="'seo_text'" class="form-control" :value="'{{ old('seo_text') }}'" :placeholder="'СЕО описание'"></Froala>
                </div>
                @if ($errors->has('seo_text'))
                    <span class="text-danger">{{ $errors->first('seo_text') }}</span>
                @endif
            </div>

            <h3><label class="mt-3 ms-3 control-label">Контакты:</label></h3>

            <div class="form-group mt-3">
                <div class="form-floating col-sm-10">
                    <label for="floatingTextarea22">Описание контактов:</label>
                    <textarea id="floatingTextarea22" class="form-control" name="contact_description" style="resize: both; max-width: 1006px; max-height: 200px" value="{{ old('contact_description') }}"></textarea>
                </div>
                @if ($errors->has('contact_description'))
                    <span class="text-danger">{{ $errors->first('contact_description') }}</span>
                @endif
            </div>

            <phone-input :value="{{ json_decode(old('phone'))}}"></phone-input>
            @if ($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Почта:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" placeholder="example@mail.ru" name="email"
                           value="{{ old('email') }}">
                </div>
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Сайт:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="website.ru" name="website"
                           value="{{ old('website') }}">
                </div>
                @if ($errors->has('website'))
                    <span class="text-danger">{{ $errors->first('website') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Ссылка на бронь:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="website.ru" name="reservation"
                           value="{{ old('reservation') }}">
                </div>
                @if ($errors->has('reservation'))
                    <span class="text-danger">{{ $errors->first('reservation') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Доп. соцсети:</label>
                <div class="col-sm-10">
                    {{-- <socialbox :elements="{{ json_encode($socialSvgs) }}" :selected="{{ json_encode($social) }}"></socialbox> --}}
                    <iconbox :elements="{{ json_encode($socialSvgs) }}" :name="'social'" :selected="{{ old('social', json_encode([])) }}"></iconbox>
                </div>
                @if ($errors->has('social'))
                    <span class="text-danger">{{ $errors->first('social') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Цена(Рубли):</label>
                <div class="col-sm-10">
                    <input type="number" min="1" step="1" class="form-control" placeholder="Цена" name="price" value="{{ old('price', 1) }}">
                </div>
                @if ($errors->has('price'))
                    <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
            </div>

            <div class="form-group mt-3">
                <h5 class="control-label col-sm-2">Пункты:</h5>
                <div class="mt-4">
                    <div class="form-group mt-2 ml-3">
                        <label for="views" class="me-1">Просмотры</label>
                        <input type="hidden" value='0' checked name="views" >
                        <input type="checkbox" value='1' name="views" @if(old('views')) checked @endif>
                    </div>
                    <div class="form-group mt-2 ml-3">
                        <label for="likes" class="me-1">Понравилось</label>
                        <input type="hidden" value='0' checked name="likes" >
                        <input type="checkbox" value='1' name="likes" @if(old('likes')) checked @endif>
                    </div>
                    <div class="form-group mt-2 ml-3">
                        <label for="comments" class="me-1">Комментарии</label>
                        <input type="hidden" value='0' checked name="comments" >
                        <input type="checkbox" value='1' name="comments" @if(old('comments')) checked @endif>
                    </div>
                </div>
            </div>


            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Очередность:</label>
                <div class="col-sm-10">
                    <input type="number" step="1" class="form-control" placeholder="Очередность" name="order" value="{{ old('order', 500) }}">
                </div>
                @if ($errors->has('order'))
                    <span class="text-danger">{{ $errors->first('order') }}</span>
                @endif
            </div>

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
{{--<script>--}}
{{--				import Optionbox from "../../../js/Admin/components/optionbox";--}}
{{--                import Tagsbox from "../../../js/Admin/components/tagsbox";--}}
{{--				export default {--}}
{{--								components: {Tagsbox, Optionbox}--}}
{{--				}--}}
{{--</script>--}}
