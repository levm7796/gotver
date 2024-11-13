@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Редактирование страницы всех статей</h2>
        <form class="form-horizontal" method="POST" action="{{ route('admin.allArticles.edit') }}">
            @csrf
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Title:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Title" name="title"
                        value="{{ old('title', optional($settings)['title']) }}">
                </div>
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Description:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Description" name="description"
                        value="{{ old('description', optional($settings)['description']) }}">
                </div>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">H1:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="H1" name="h1"
                        value="{{ old('h1', optional($settings)['h1']) }}">
                </div>
                @if ($errors->has('h1'))
                    <span class="text-danger">{{ $errors->first('h1') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">SEO текст:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="SEO текст" name="seo_text"
                        value="{{ old('seo_text', optional($settings)['seo_text']) }}">
                </div>
                @if ($errors->has('seo_text'))
                    <span class="text-danger">{{ $errors->first('seo_text') }}</span>
                @endif
            </div>
            <div class="form-group mt-3">
                <div class="form-check">
                    <input type="hidden" name="news_carousel" value="0">
                    <input type="checkbox" id="phoneConfirmation4" value="1" class="form-check-input"
                        name="news_carousel"
                        {{ old('news_carousel', optional($settings)['news_carousel']) ? 'checked' : '' }}>
                    <label class="form-check-label" for="phoneConfirmation4">Новости как карусель</label>
                </div>
            </div>
            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Статья в конце:</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Права" name="article_id">
                        <option value="-1" {{ -1 == (old('article_id', optional($settings)['article_id'])) ? 'selected' : '' }}>Выводить последний созданый</option>
                        <option value="0" {{ 0 == (old('article_id', optional($settings)['article_id'])) ? 'selected' : '' }}>Не выводить</option>
                        <option disabled>----------</option>
                        @foreach($articles as $article)
                            <option value="{{$article->id}}" {{ $article->id == (old('article_id', optional($settings)['article_id'])) ? 'selected' : '' }}>{{ $article->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($errors->has('article_id'))
                    <span class="text-danger">{{ $errors->first('article_id') }}</span>
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
