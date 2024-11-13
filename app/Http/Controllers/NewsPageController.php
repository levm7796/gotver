<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\News;
use App\Models\newsTag;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsPageController extends Controller
{
    public function index($news) {
        $article = News::where('id', $news->id)->where('type', '0')->first();
        if(!$article){
            abort(404);
        }
        return $this->returnNew($news);
    }

    public function articleIndex($article){
        $article = News::where('id', $article)->where('type', '1')->first();
        if(!$article){
            abort(404);
        }
        return $this->returnNew($article);
    }

    function returnNew(News $news){
        $news->viewsCount = $news->viewsCount + 1;
        $news->save();

        foreach ($news->blocks as $block) {
            $blocks[] = json_decode($block, true);
        }
        if(!isset($blocks[0])) {
            $blocks = null;
        }
        // dd($blocks);
        $tags = $news->tags;

        // if(isset($tagIds)) {
        //     foreach ($tagIds as $key => $value) {
        //         $response = Tag::where('id', $value)->get()->toArray();
        //         $tags[] = $response[0];
        //     }
        // } else {
        //     $tags = [];
        // }


        $comments = Comment::where('table_name', $news->getTable())->where('item_id', $news->id)->whereNull('answered_msg')->with('likes', 'user', 'answers')->limit(3)->get()->toArray();
        $favorite = [];

        if(Auth::user()) {
            if(count(Favorite::where('user_id', Auth::user()->id)->where('table_name', $news->getTable())->where('item_id', $news->id)->get()) == 0) {
                $favorite['check'] = false;
            } else {
                $favorite['check'] = true;
            }
        } else {
            $favorite['check'] = false;
        }

        return view('pages.indexNews', compact('news', 'blocks', 'tags', 'comments', 'favorite'));
    }
}
