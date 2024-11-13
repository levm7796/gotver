@extends('admin.layout')
@section('content')
    <div class="container mt-5">
        <h2>Редактирование правил пользования платформой</h2>
        <form class="form-horizontal" method="POST" >
            @csrf

            <div class="form-group mt-3">
                <label class="control-label col-sm-2">Описание:</label>
                <div class="col-sm-10">
                    <textarea class="editor" name="description2" value="{{ old('content', $settings) }}"></textarea>
                </div>
                <input type="hidden" class="true-form" name="content">
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
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
@section('end-page')
<script>
    $('.selectpicker').selectpicker();
    new FroalaEditor('.editor', {placeholderText: 'Текст...', pastePlain: true})
</script>
<style>
.fr-wrapper > div:first-of-type:has(a) {
    display: none;
}
</style>
<script>
    document.querySelector('.form-horizontal').addEventListener('submit', function(event) {
        event.preventDefault(); // Предотвратить стандартное поведение отправки формы
        
        let description2 = document.querySelector('.editor');
        let description = document.querySelector('.true-form');
        description.value = removeLastPElementWithAttribute(description2.value)
        this.submit();
    });
    function removeLastPElementWithAttribute(htmlString) {
        // Создаем временный элемент для работы с HTML
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = htmlString;

        // Найти все элементы <p> с атрибутом data-f-id="pbf"
        const paragraphs = tempDiv.querySelectorAll('p[data-f-id="pbf"]');
        
        let description = document.querySelector('.editor');

        // Удаляем последний найденный элемент, если он существует
        // Удаляем последний найденный элемент, если он существует
        if (paragraphs.length > 0) {
            const lastParagraph = paragraphs[paragraphs.length - 1];
            lastParagraph.remove();
        }
         return tempDiv.innerHTML;
    }
</script>
@endsection
