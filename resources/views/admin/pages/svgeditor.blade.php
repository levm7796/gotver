@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Редактирование SVG Спрайта</h2>
        <form class="form-horizontal" method="POST" >
            @csrf

            <div class="form-group mt-3">
                <div>
                    <add-svg />
                </div>
                <label class="control-label col-sm-2">Содержимое SVG: </label>
                <div class="col-sm-10">
                    <textarea id="content" placeholder="Содержимое SVG" name="content"
                        value="{{ old('content', $content) }}" id="" rows="30" style="width: 100%"></textarea>
                </div>
            </div>
 

            <div class="form-group row mt-3">
                <div class="col-sm-offset-2 col-sm-1">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
