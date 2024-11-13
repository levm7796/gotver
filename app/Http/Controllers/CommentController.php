<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Hotel;
use App\Models\Like;
use App\Models\News;
use App\Services\MyService;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::query();
        if ($request->has('message') && $request->input('message') != '') {
            $comments->where('message', 'like', '%' . $request->input('message') . '%');
        }
        if ($request->has('cheked') && $request->input('cheked') != '') {
            $comments->where('cheked', $request->input('cheked'));
        }
        if ($request->has('s') && $request->has('d')) {
            $sort = $request->input('s');
            $direction = $request->input('d') == 'asc' ? 'asc' : 'desc';
            $comments->orderBy($sort, $direction);
        }
        $comments = $comments->paginate(15)->withQueryString();;
        return view('admin.comments.index', compact('comments'));
    }

    public function edit(Comment $comment){
        return view('admin.comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment){
        $comment->message = $request->message;
        $comment->cheked = $request->cheked;
        $comment->save();
        return redirect()->route('admin.comments.index');
    }
    function store(Request $request) {
        $this->validate($request, [
            'comment' => 'required|max:500',
        ]);
        $comment = New Comment();
        $comment->user_id = Auth::user()->id;
        $comment->message = $request->comment;
        $comment->table_name = request()->table;
        $comment->item_id = (int)request()->id;
        if(Auth::user()->role_id <= 2)
            $comment->cheked = 1;
        $comment->save();
        MyService::mailMessageAdmin('Новый коментарий', route('admin.comments.edit', $comment->id));
        if(request()->table == "news"){
            $news = News::whereId(request()->id)->first();
            $oldValue = $news->commentsCount;
            News::whereId(request()->id)->update(array('commentsCount' => $oldValue + 1));
        } else {
            $hotel = Hotel::whereId(request()->id)->first();
            $oldValue = $hotel->commentsCount;
            Hotel::whereId(request()->id)->update(array('commentsCount' => $oldValue + 1));
        }
        return Redirect::to(URL::previous() . "#comments");
    }
    function answer(Request $request) {
        $comment = New Comment();
        $comment->user_id = Auth::user()->id;
        $comment->message = $request->comment;
        $comment->table_name = request()->table;
        $comment->item_id = (int)request()->id;
        $comment->answered_msg = request()->commentId;
        if(Auth::user()->role_id <= 2)
            $comment->cheked = 1;
        $comment->save();
        MyService::mailMessageAdmin('Новый коментарий', route('admin.comments.edit', $comment->id));
        if(request()->table == "news"){
            $news = News::whereId(request()->id)->first();
            $oldValue = $news->commentsCount;
            News::whereId(request()->id)->update(array('commentsCount' => $oldValue + 1));
        } else {
            $hotel = Hotel::whereId(request()->id)->first();
            $oldValue = $hotel->commentsCount;
            Hotel::whereId(request()->id)->update(array('commentsCount' => $oldValue + 1));
        }

        return Redirect::to(URL::previous() . "#comments");
    }
    function like(Request $request) {
        $comment = Comment::whereId(request()->id)->firstOrFail();
        // $record = $comment->likes()->where('user_id', Auth::user()->id)->first();
        $like = null;
        $fingerprint = MyService::getFingerprint();
        if(Auth::check()){
            $like = Like::where('comment_id', $comment->id)->where('user_id', Auth::user()->id)->first();
        } else {
            $like = Like::where('comment_id', $comment->id)->where('user_id', null)->where('fingerprint', $fingerprint)->first();
        }
        if($like){
            $like->like = intval(request()->like);
            $like->save();
        } else {
            $like = New Like;
            $like->like = request()->like;
            $like->comment_id = request()->id;
            $like->user_id = Auth::check() ? Auth::user()->id : null;
            $like->fingerprint = $fingerprint;


            $like->save();
        }

        return response()->json(['likes'=>$comment->getLikeCount(), 'dislike' => $comment->getDislikeCount()]);
    }
//    function changeLike(Request $request) {
//        $comment = Comment::whereId(request()->id)->first();
//        $userId = Auth::user()->id;
//        $likes = $comment->likes()->where('user_id', $userId)->delete();
//    }
    function favorite(Request $request) {
        $userId = Auth::user()->id;
        $newsId = request()->id;
        $table = request()->table;
        if(count(Favorite::where('user_id', $userId)->where('table_name', $table)->where('item_id', $newsId)->get()) == 0) {
            $favorite = New Favorite();
            $favorite->user_id = $userId;
            $favorite->table_name = $table;
            $favorite->item_id = $newsId;
            $favorite->save();
            $news = News::whereId($newsId)->get();
            $oldValue = $news[0]->likesCount;
            News::whereId($newsId)->update(array('likesCount' => $oldValue + 1));
            return true;
        } else {
            Favorite::where('user_id', $userId)->where('table_name', $table)->where('item_id', $newsId)->delete();
            $news = News::whereId($newsId)->get();
            $oldValue = $news[0]->likesCount;
            News::whereId($newsId)->update(array('likesCount' => $oldValue - 1));
            return false;
        }
    }
    function showMore(Request $request) {
        $comments = Comment::where('table_name', $request->table)->where('item_id', $request->id);
        switch($request->filter){
            case '1':
                $comments->orderBy('created_at', 'desc');
                break;
            case '2':
                $comments->orderBy('created_at', 'asc');
                break;
            case '3':
                // TODO/TO_DO этот жойн можнозаменить на динамическую таблицу(readonly) с автоматическими подсчетами  количества. очень сильно облехчит запросы к бд
                $comments->select('comments.*')
                         ->leftJoin(DB::raw('(SELECT comment_id,
                                            SUM(CASE WHEN `like` = 1 THEN 1 ELSE 0 END) as like_count,
                                            SUM(CASE WHEN `like` = 0 THEN 1 ELSE 0 END) as dislike_count
                                    FROM likes
                                    GROUP BY comment_id) as like_dislike_counts'),
                        'comments.id', '=', 'like_dislike_counts.comment_id');
                $comments->orderBy('like_count', 'desc');
                break;
            case '4':
                $comments->select('comments.*')
                         ->leftJoin(DB::raw('(SELECT comment_id,
                                            SUM(CASE WHEN `like` = 1 THEN 1 ELSE 0 END) as like_count,
                                            SUM(CASE WHEN `like` = 0 THEN 1 ELSE 0 END) as dislike_count
                                    FROM likes
                                    GROUP BY comment_id) as like_dislike_counts'),
                        'comments.id', '=', 'like_dislike_counts.comment_id');
                $comments->orderBy('dislike_count', 'desc');
                break;
        }

        $comments = $comments->paginate(3)->withQueryString();
        $items = $comments->items();
        $hasMorePages = $comments->hasMorePages();
        $htmlComments = [];
        // dd($items);
        foreach($items as $cm){
            $htmlComments[] = View::make('parts.comment-item', ['comment' => $cm, 'itemId' => $request->id, 'tableName' => $request->table])->render();
        }
        return response()->json(['status' => 200, 'html' => implode('', $htmlComments), 'hasMorePages' => $hasMorePages]);
    }


    public function destroy(Request $request, Comment $comment){
        MyLogingController::addLog('Удаление коментария', json_encode($comment));

        if($comment->table_name == "news"){
            $news = News::whereId($comment->item_id)->first();
            $oldValue = $news->commentsCount;
            News::whereId($comment->item_id)->update(array('commentsCount' => $oldValue + 1));
        } else {
            $hotel = Hotel::whereId($comment->item_id)->first();
            $oldValue = $hotel->commentsCount;
            Hotel::whereId($comment->item_id)->update(array('commentsCount' => $oldValue + 1));
        }

        $comment->delete();

        return redirect()->route('admin.comments.index');
    }

    public function destroy2(Request $request, Comment $comment){
        MyLogingController::addLog('Веб удаление коментария', json_encode($comment));
        $comment->delete();
        return "1";
    }
}
