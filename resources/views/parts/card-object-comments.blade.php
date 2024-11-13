<div class="card-object__comments" id="comments">
    <p class="card-object__title-h2">Комментарии</p>
    <div class="card-object__comments-action-panel">
        <div class="card-object__comments-select-group">
        <p style="width: 200px;">Сортировать по:</p>
        <div class="custom-select" data-select data-name="object-select">
            <button class="custom-select__button" type="button" aria-label="Выберите одну из опций">
                <span class="custom-select__text"></span><span class="custom-select__icon"></span>
            </button>
            <ul class="custom-select__list" role="listbox">
            <li class="custom-select__item" tabindex="0" data-select-value="1" aria-selected="true" role="option">Сначала старые</li>
            <li class="custom-select__item" tabindex="0" data-select-value="2" aria-selected="false" role="option">Сначала новые</li>
            <li class="custom-select__item" tabindex="0" data-select-value="3" aria-selected="false" role="option">По лайкам</li>
            <li class="custom-select__item" tabindex="0" data-select-value="4" aria-selected="false" role="option">По дизлайкам</li>
            </ul>
        </div>
        </div>
        <button class="main-btn" type="button" onclick="tryComment(0)"><span>Добавить комментарий</span>
        <svg width="40" height="40" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#arrow-black"></use>
        </svg>
        </button>
    </div>
    <form method="POST"
        action="{{ route('addComment', ['id' => $itemId, 'table' => $tableName]) }}"
        class="commentForm commentForm-0" style="display: none">
        @csrf
        <div style="display: flex; flex-direction: column;width: 500px; align-items: end">
            <textarea name="comment" id="comment" "
                style="border: 1px solid #27292e; border-radius: 10px; padding: 5px; width: 500px; height: 75px"></textarea>
            <button
                style="border: 1px solid #27292e; border-radius: 10px; width: 100px; height: 30px; margin-top: 10px; cursor: pointer"
                type="submit" id="addComment" >Добавить</button>
        </div>
    </form>
    <div class="card-object__comments-wrapper" >
        <div class="card-object__comments-inner" >
            @foreach($comments as $comment)
                @include('parts.comment-item')
            @endforeach

        </div>
        @if(count($comments) >=3)
        <button class="button-more" hidden showmore-button type="button" onclick="loadMore()">
            <svg width="24" height="24" aria-hidden="true">
                <use xlink:href="/img/sprite.svg#arrow-more"></use>
            </svg>
            <span class="button-more__more">Показать еще</span>
            {{-- <span class="button-more__less">Спрятать</span> --}}
        </button>
        @endif
    </div>
</div>
<script>
    let inAnsverItem = null;
    let filterParameter = 1;
    let currentCommentPage = 1;
    function tryComment(index){
        let auth = {{ Auth::check() ? 'true' : 'false' }};
        document.querySelectorAll('.commentForm').forEach(form => {
            form.querySelector('textarea').value = ''
            form.style.display = 'none'
        })
        if(inAnsverItem == index){
            inAnsverItem = null
        } else {
            if(auth){
                inAnsverItem = index
                document.querySelector('.commentForm-'+index).style.display = 'block'
            } else {
                modals.open('login-to-account')
            }
        }
    }
    function likeComment(id, val){
        let csrf = document.querySelector('meta[name="csrf-token"]').content;
        axios.post(`/comment/${id}/${val}`, {
            headers: {
                'X-CSRF-Token': csrf
            }
        }).then(res => {
            if(res?.data?.likes){
                document.querySelector(`[data-activity-plus][comment-${id}] span`).innerHTML = res?.data?.likes
            }
            if(res?.data?.dislike){
                document.querySelector(`[data-activity-minus][comment-${id}] span`).innerHTML = res?.data?.dislike
            }
            // location.reload()
        })
    }
    function loadMore(clear = false){
        let csrf = document.querySelector('meta[name="csrf-token"]').content;
            axios.post(`/comments/{{ $tableName }}/{{ $itemId }}/${filterParameter}/?page=${currentCommentPage+1}`, {
                headers: {
                    'X-CSRF-Token': csrf
                }
            }).then(res => {
                if(res?.data?.status == 200){
                    currentCommentPage = currentCommentPage + 1
                    document.querySelector('[showmore-button]').style.display = res?.data?.hasMorePages ? 'block' : 'none'
                    console.log(document.querySelector('.card-object__comments-inner'))
                    console.log(res?.data)
                    let div = document.createElement('div')
                    div.innerTHML =res?.data?.html
                    console.log(div)
                    if(clear)
                        document.querySelector('.card-object__comments-inner').innerHTML = res?.data?.html
                    else
                        document.querySelector('.card-object__comments-inner').insertAdjacentHTML('beforeend', res?.data?.html);
                }
            })
    }
    document.querySelectorAll('.custom-select__item').forEach(item => {
        item.addEventListener('click', function() {
            filterParameter = this.getAttribute('data-select-value');
            currentCommentPage = 0
            loadMore(true);
        });
    });

</script>
