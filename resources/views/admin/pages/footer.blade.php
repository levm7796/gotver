@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Редактирование подвала сайта</h2>
        <form class="form-horizontal" method="POST" action="{{ route('admin.footer.edit') }}">
            @csrf

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

            <div class="form-group row mt-3">
                <div class="col-sm-offset-2 col-sm-1">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
