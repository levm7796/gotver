<section class="tag-search">
    <div class="container">
       <div class="main-title">
          <h2>Теги, которые чаще всего&nbsp;ищут</h2>
          <p class="main-title__description">В рамках спецификации современных стандартов, акционеры крупнейших
             компаний освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы,
             разумеется, в равной степени предоставлены сами себе.
          </p>
       </div>
       <div class="tag-search__wrapper">
            @foreach($lct->getAllTagsBySettings() as $tag)
            <a class="tag-item" href="{{ $tag->myUrl() }}" data-tag="{{ $tag->name }}" data-color="purple">
                <svg width="16" height="16" aria-hidden="true">
                    <use xlink:href="/img/sprite.svg#tag"></use>
                </svg>
                <span>{{ $tag->name }}</span>
            </a>
            @endforeach
          {{-- <a class="main-btn" href="#">
             <span>Посмотреть всё</span>
             <svg width="40" height="40" aria-hidden="true">
                <use xlink:href="/img/sprite.svg#arrow-black"></use>
             </svg>
          </a> --}}
       </div>
    </div>
 </section>
