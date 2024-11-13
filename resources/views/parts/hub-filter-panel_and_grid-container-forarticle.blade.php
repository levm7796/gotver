<div class="filter-panel">
    <div class="tag-panel swiper" data-showmore="items" data-showmore-media="768,min">
        <div class="tag-panel__wrapper swiper-wrapper" data-showmore-content="1">
            @foreach($blockTags as $key => $tag)
            <a class="tag-item swiper-slide" href="javascript:void(0)" data-tag="{{ $tag->name }}" data-color="{{ ['red', 'green', 'purple', 'blue'][$key % 4] }}"
                tagid="{{ $tag->id }}"
            >
                <svg width="16" height="16" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#tag"></use>
                </svg><span>{{ $tag->name }}</span>
            </a>
            @endforeach
        </div>
        <button class="btn-showmore-round" type="button" hidden
            data-showmore-button><span></span><span></span></button>
    </div>
    @if(!isset($hideSort) || $hideSort == false)
    <div class="custom-select" data-select data-name="object-select">
        <button class="custom-select__button" type="button" aria-label="Выберите одну из опций"><span
                class="custom-select__text"></span><span class="custom-select__icon"></span></button>
        <ul class="custom-select__list" role="listbox">
            <li class="custom-select__item" tabindex="0" data-select-value="parameter-1" aria-selected="true"
                role="option">Последние</li>
            {{-- <li class="custom-select__item" tabindex="0" data-select-value="parameter-2" aria-selected="false"
                role="option">Сначала дешевле</li>
            <li class="custom-select__item" tabindex="0" data-select-value="parameter-3" aria-selected="false"
                role="option">Сначала дороже</li> --}}
            <li class="custom-select__item" tabindex="0" data-select-value="parameter-4" aria-selected="false"
                role="option">По рейтингу</li>
            <li class="custom-select__item" tabindex="0" data-select-value="parameter-5" aria-selected="false"
                role="option">По комментариям</li>
            <li class="custom-select__item" tabindex="0" data-select-value="parameter-6" aria-selected="false"
                role="option">По просмотрам</li>
        </ul>
    </div>
    @endif
</div>
<div class="grid-container" data-showmore="items">
    <div class="grid-container__inner" data-showmore-content="{{ min(max(floor(count($blockHotels) / 3), 1), 5) }}">
        @include('parts.hub-hotel-items-articles', ['hotels' => $blockHotels])
    </div>
    @if(count($blockHotels) > 15)
    <button class="button-more" hidden @if(!isset($hideBtnJs) || $hideBtnJs == false) data-showmore-button @endif type="button">
        <svg width="24" height="24" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#arrow-more"></use>
        </svg><span class="button-more__more">Показать еще</span><span
            class="button-more__less">Спрятать</span>
    </button>
    @endif
</div>
@if(!isset($hideJS) || $hideJS == false)
<script>
    let filterState = null;
    let tagId = null;
    let hubId = {{ empty($hubId) ? 'null' : $hubId }};
    document.addEventListener('click', function(event) {
        if (event.target.closest('.custom-select__item')) {
            filterState = event.target.getAttribute('data-select-value').split('-')?.[1]
            fetchHotels(event.target.closest('.container'));
        }
        if (event.target.closest('.tag-item')) {
            handleTagClick(event.target.closest('.tag-item'));
        }
        function handleTagClick(btn){
            console.log('handleTagClick', btn)
            btn.closest('.tag-panel').querySelector('.tag-item.active')?.classList?.remove('active')
            btn.classList.add('active')
            tagId = btn.getAttribute('tagid')
            fetchHotels(btn.closest('.container'));
        }
        function fetchHotels(parentBlock){
            const data = {
                filterState,
                tagId,
                hubId,
            };
            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(data)
            };

            fetch('/hub/articles-sort', options)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if(data.status == 200){
                        parentBlock.querySelector('.grid-container__inner').innerHTML = data.list
                    }
                    console.log('Успешная авторизация:', data);
                })
                .catch(error => {
                    console.log('Произошла ошибка:', error);
                });
        }
    });
</script>
@endif
