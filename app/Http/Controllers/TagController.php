<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Hotel;
use App\Models\HotelTags;
use App\Models\News;
use App\Models\Tag;
use App\Services\MyService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::query();
        if ($request->has('name') && $request->input('name') != '') {
            $tags->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('type') && $request->input('type') != '') {
            $tags->where('type', 'like', '%' . $request->input('type') . '%');
        }
        if ($request->has('s') && $request->has('d')) {
            $sort = $request->input('s');
            $direction = $request->input('d') == 'asc' ? 'asc' : 'desc';
            $tags->orderBy($sort, $direction);
        }

        $tags = $tags->paginate(15)->withQueryString();
        return view('admin.tags.index', compact('tags'));
    }
    public function create()
    {
//        $svgs = $this->getSvg();
        $articles = News::where('type', '2')->get();
        return view('admin.tags.add', compact('articles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'type' => 'in:0,1,2',
            'order' => 'integer|min:0',
        ]);
        $tag = new Tag();
        $tag->name = $request->name;
        $tag->type = $request->type;
        $tag->order = $request->order;
        $tag->soundex = $tag->mySoundex($tag->name);
        MyLogingController::addLog('Добавлен тэг', json_encode($tag));
        $tag->save();

        $data = [];
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['article_id'] = $request->article_id;
        $tag->setContent($data);

        return redirect()->route('admin.tags.index');
    }

    public function edit(Tag $tag)
    {
        $articles = News::where('type', '2')->get();
        $tags = Tag::whereNot('id', $tag->id)->get();
        return view('admin.tags.edit', compact('tag', 'tags', 'articles'));
    }

    public function update(Request $request, Tag $tag){
        $this->validate($request, [
            'name' => 'required|max:255',
            'type' => 'in:0,1,2',
            'order' => 'integer|min:0',
        ]);

        $tag->name = $request->name;
        $tag->type = $request->type;
        $tag->order = $request->order;
        $tag->soundex = $tag->mySoundex($tag->name);
        MyLogingController::addLog('Отредактирован тэг', json_encode($tag->getDirty()));
        $tag->save();

        $data = [];
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['article_id'] = $request->article_id;
        $data['article_text'] = $request->article_text;
        $data['additional_tags_add'] = $request->additional_tags_add;
        $data['additional_tags_remove'] = $request->additional_tags_remove;
        $tag->setContent($data);

        return redirect()->route('admin.tags.index');
    }

    public function destroy(Request $request, Tag $tag){
        MyLogingController::addLog('Удален тэг', json_encode($tag));
        $tag->delete();

        return redirect()->route('admin.tags.index');
    }

    public function tagIndex($tag){
        $tag = Tag::where('id', $tag)->first();
        if(!$tag){
            abort(404);
        }
        $settings = $tag->getContent();
        // $words = preg_split('/[\s,;]+/', $tag->name, -1, PREG_SPLIT_NO_EMPTY);
        // $tags = Tag::where(function($query) use ($words) {
        //     foreach ($words as $word) {
        //         $query->orWhere('name', 'like', '%' . $word . '%');
        //     }
        // })
        // ->where('id', '!=', $tag->id)
        // ->get();
        // dd(optional($settings)['additional_tags_add'], optional($settings)['additional_tags_remove']);
        $tags = $tag->getSameTags(null, optional($settings)['additional_tags_add'], optional($settings)['additional_tags_remove']);

        $uniqueHotelsTags = $tags->filter(function ($tag) {
            return $tag->type === '0';
        });
        $firstHotelsId = HotelTags::where('tag_id', optional(optional($uniqueHotelsTags)[0])->id)->pluck('hotel_id')->toArray();
        $hotels = Hotel::whereIn('id', $firstHotelsId)->get();

        $article = [];
        $article['show'] = false;
        if(isset($settings['article_id'])){
            switch($settings['article_id']){
                case -1:
                    $art = News::where('type', '2')->orderBy('created_at', 'desc')->first();
                    $comments = Comment::where('table_name', $art->getTable())->where('item_id', $art->id)->whereNull('answered_msg')->with('likes', 'user', 'answers')->limit(3)->get()->toArray();
                    foreach ($art->blocks as $block) {
                        $blocks[] = json_decode($block, true);
                    }
                    if(!isset($blocks[0])) {
                        $blocks = null;
                    }
                    $article['show'] = true;
                    $article['article'] = $art;
                    $article['comments'] = $comments;
                    $article['blocks'] = $blocks;
                    $article['tags'] = $art->tags;
                    break;
                case 0:
                    $article['show'] = false;
                    break;
                default:
                    $art = News::where('type', '2')->where('id', $settings['article_id'])->first();
                    $comments = Comment::where('table_name', $art->getTable())->where('item_id', $art->id)->whereNull('answered_msg')->with('likes', 'user', 'answers')->limit(3)->get()->toArray();
                    foreach ($art->blocks as $block) {
                        $blocks[] = json_decode($block, true);
                    }
                    if(!isset($blocks[0])) {
                        $blocks = null;
                    }
                    $article['show'] = true;
                    $article['article'] = $art;
                    $article['comments'] = $comments;
                    $article['blocks'] = $blocks;
                    $article['tags'] = $art->tags;
                    break;
            }
        }
        return view('pages.tag', compact('tag', 'tags', 'settings', 'article', 'uniqueHotelsTags', 'hotels'));
    }
}
