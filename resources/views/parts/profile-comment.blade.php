<div class="comment-account-item">
    <div class="comment-account-item__head">
        <p class="comment-account-item__head-main"><span
                class="comment-account-item__you">Вы,</span>
                @if($comment->answered_msg)
                    <span class="comment-account-item__action">ответили</span>
                    @php
                        $ansveredItem = $comment->getItem();
                        $name = $comment->user->name
                    @endphp
                @else
                    <span class="comment-account-item__action">прокомментировали</span>
                    @php
                        $ansveredItem = $comment->getItem();
                        $name = $ansveredItem->name
                    @endphp
                @endif
                <a class="comment-account-item__link" href="{{ $ansveredItem->myUrl() }}">
                    <span>{{ $name }}</span>
                    <svg width="12" height="12" aria-hidden="true">
                        <use xlink:href="/img/sprite.svg#link"></use>
                    </svg>
                </a>
        </p>
        <time datetime="{{ $comment['updated_at'] }}">{{ AppHelper::instance()->formatDate($comment['updated_at']) }}</time>
    </div>
    <p class="comment-account-item__text">{{ $comment->message }}</p>
</div>
