<div class="comment-item">
    <div class="comment-item__main-wrapper">
    <div class="comment-item__header
        @if($comment->user->role_id <= 2)
            comment-item__reply--manager
        @endif
        ">
        <div class="comment-item__avatar">
            <picture>
                {{-- <source type="image/webp" srcset="/img/content/avatars/avatar-01.webp, img/content/avatars/avatar-01@2x.webp 2x"> --}}
                <img src="{{ $comment->user->validAvatar }}" srcset="{{ $comment->user->validAvatar }}" width="48" height="48" alt="аватар" loading="lazy">
            </picture>
        </div>
        @if($comment->user->role_id <= 1)
            <p class="comment-item__name">Администратор GoTver.Ru</p>
        @elseif($comment->user->role_id <= 2)
            <p class="comment-item__name">Менеджер GoTver.Ru</p>
        @else
            <p class="comment-item__name">{{ $comment->user->name }}</p>
        @endif
        <time class="comment-item__date" datetime="{{ $comment->updated_at }}">{{ AppHelper::instance()->formatDate($comment->updated_at) }}</time>
    </div>
    <p class="comment-item__main">{{ $comment->message }}</p>
    <div class="comment-item__footer">
        <button class="comment-item__reply-button" type="button">
        <svg width="20" height="20" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#arrow-turn-down"></use>
        </svg><span class="comment-item__reply-button-text" onclick="tryComment({{ $comment->id }})">Ответить</span><span class="comment-item__reply-button-count">({{ count($comment->answers) }})</span>
        </button>
        <div class="comment-item__activity">
        <button class="comment-item__activity-button no-zero" type="button" data-activity-plus {{ 'comment-'.$comment->id }} onclick="likeComment({{ $comment->id }}, 1)">
            <svg width="20" height="20" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#like-finger"></use>
            </svg><span>{{ $comment->getLikeCount() }}</span>
        </button>
        <button class="comment-item__activity-button no-zero" type="button" data-activity-minus {{ 'comment-'.$comment->id }} onclick="likeComment({{ $comment->id }}, 0)">
            <svg width="20" height="20" aria-hidden="true">
            <use xlink:href="/img/sprite.svg#like-finger"></use>
            </svg><span>{{ $comment->getDislikeCount() }}</span>
        </button>
        </div>
    </div>
    <form method="POST"
        action="{{ route('answerComment', ['id' => $itemId, 'table' => $tableName, 'commentId' => $comment->id]) }}"
        class="commentForm commentForm-{{$comment->id}}" style="display:none">
        @csrf
        <div style="display: flex; flex-direction: column;width: 500px; align-items: end">
            <textarea name="comment" id="comment"
                style="border: 1px solid #27292e; border-radius: 10px; padding: 5px; width: 500px; height: 75px"></textarea>
            <button
                style="border: 1px solid #27292e; border-radius: 10px; width: 100px; height: 30px; margin-top: 10px; cursor: pointer"
                type="submit" id="addComment" >Добавить</button>
        </div>
    </form>
    </div>
    <div class="comment-item__replies-wrapper">
        @foreach($comment->answers as $answer)
        <div class="comment-item__reply
            @if($answer->user->role_id <= 2)
            comment-item__reply--manager
            @endif
            ">
            <div class="comment-item__header">
            @if($answer->user->role_id <= 1)
                <p class="comment-item__name">Администратор GoTver.Ru</p>
            @elseif($answer->user->role_id <= 2)
                <p class="comment-item__name">Менеджер GoTver.Ru</p>
            @else
                <p class="comment-item__name">{{ $answer->user->name }}</p>
            @endif
            <time class="comment-item__date" datetime="{{ $answer->updated_at }}">{{ AppHelper::instance()->formatDate($answer->updated_at) }}</time>
            </div>
            <p class="comment-item__main">{{ $answer->message }}</p>
        </div>
        @endforeach
    </div>
</div>
