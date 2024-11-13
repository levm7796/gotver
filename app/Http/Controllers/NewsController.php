<?php

namespace App\Http\Controllers;

use App\Models\BlocksNews;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Hotel;
use App\Models\Hub;
use App\Models\Location;
use App\Models\News;
use App\Models\NewsTag;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\tags_news;
use App\Models\tagsNews;
use App\Services\MyService as MyService;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use stdClass;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = News::query()->where('type', '0');
        if ($request->has('name') && $request->input('name') != '') {
            $news->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('location_id') && $request->input('location_id') != '') {
            $hotels->where('location_id', $request->input('location_id'));
        }
        if ($request->has('hub_id') && $request->input('hub_id') != '') {
            $hotels->where('hub_id', $request->input('hub_id'));
        }
        if ($request->has('activenow') && $request->input('activenow') != '') {
            $articles->where('created_at', '<=', $request->input('activenow'));
            $articles->where('end_date', '>=', $request->input('activenow'))->orWhereNull('end_date');
        }
        if ($request->has('s') && $request->has('d')) {
            $sort = $request->input('s');
            $direction = $request->input('d') == 'asc' ? 'asc' : 'desc';
            $news->orderBy($sort, $direction);
        }

        $news = $news->paginate(15)->withQueryString();
        $locations = Location::all();
        $hubs = Hub::all();

        return view('admin.news.index', compact('news', 'locations', 'hubs'));
    }

    public function create()
    {
        $tags = Tag::query()->where('type', '1')->get();
        $locations = Location::all();
        $hubs = Hub::all();
        return view('admin.news.add', compact('tags', 'locations', 'hubs'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'location_id' => 'required|exists:locations,id',
            'hub_id' => 'required|exists:hubs,id',
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            // 'img' => 'required',
            'signature' => 'nullable|max:255',
            'tagsId.*' => 'exists:tags,id',
            'description' => 'string|max:5000',
            'coordinates' => 'max:255',
            'order' => 'integer|min:0',
        ]);

        // check if directory exist
        File::ensureDirectoryExists(public_path('images'));
        // $fileArr = ['newFileName'=>'', 'thumbNewFileName' => ''];
        // if($request->hasFile('img'))
        //     $fileArr = MyService::compressImg('img', $request, false);
        $userId = Auth::user()->id;

        $news = new News();
        $news->location_id = $request->location_id;
        $news->hub_id = $request->hub_id;
        $news->name = $request->name;
        $news->img = isset($request->img) ? $request->img : '';
        $news->thumbImg =  isset($request->thumbImg) ? $request->thumbImg : '';
        $news->description = $request->description;
        $news->title = $request->title;
        $news->signature = isset($request->signature) ? $request->signature : '';
        $news->coordinates = isset($request->coordinates) ? $request->coordinates : '';
        $news->data = date("j F, Y");
        $news->author = $userId;
        $news->order = $request->order;
        if(($request->views)) {
            $news->views = true;
        } else {
            $news->views = false;
        }
        if(($request->likes)) {
            $news->likes = true;
        } else {
            $news->likes = false;
        }
        if(($request->comments)) {
            $news->comments = true;
        } else {
            $news->comments = false;
        }
        MyLogingController::addLog('Добавлена новость', json_encode($news));
        $news->save();

        BlockController::setBlock($request->blocks, $news, false);

        $tagsId = $request->tagsId;
        $news->tags()->sync($tagsId);


        return redirect()->route('admin.news.index');
    }
    public function edit(News $news)
    {
        foreach ($news->blocks as $block) {
            $blocks[] = json_decode($block, true);
        }
        if(!isset($blocks[0])) {
            $blocks = null;
        }

        $allTags = Tag::query()->where('type', '1')->get();
//
//        foreach ($news->tags as $tag) {
//            $tags[] = $tag->id;
//        }
//
//       if(isset($tagIds)) {
//           foreach ($tagIds as $key => $value) {
//               $response = Tag::where('id', $value)->get()->toArray();
//               $tags[] = $response[0];
//           }
//       } else {
//           $tags = [];
//       }

        $locations = Location::all();
        $hubs = Hub::all();
        $author = User::findOrFail($news->author)->pluck('name')->toArray()[0];
        return view('admin.news.edit', compact('news', 'blocks', 'allTags', 'author', 'locations', 'hubs'));
    }
    public function update(Request $request, News $news) {
        $this->validate($request, [
            'location_id' => 'required|exists:locations,id',
            'hub_id' => 'required|exists:hubs,id',
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'signature' => 'nullable|max:255',
            'tagsId.*' => 'exists:tags,id',
            'description' => 'string|max:5000',
            'coordinates' => 'max:255',
            'order' => 'integer|min:0',
        ]);

        // check if directory exist
        File::ensureDirectoryExists(public_path('images'));


        // if(!is_null($request->img)) {
        //     $fileArr = MyService::compressImg('img', $request, false);
        // } else {
        //     $fileArr = ['newFileName' => $request->oldImg, 'thumbNewFileName' => $request->oldThumbImg];
        // }

        // $userId = Auth::user()->id;

        $news->location_id = $request->location_id;
        $news->hub_id = $request->hub_id;
        $news->name = $request->name;
        $news->img = isset($request->img) ? $request->img : '';
        $news->thumbImg =  isset($request->thumbImg) ? $request->thumbImg : '';
        $news->description = $request->description;
        $news->title = $request->title;
        $news->signature = isset($request->signature) ? $request->signature : '';
        $news->coordinates = isset($request->coordinates) ? $request->coordinates : '';
        $news->data = date("j F, Y");
        // $news->author = $userId;
        $news->order = $request->order;
        $news->created_at = $request->created_at;
        if(isset($request->views)) {
            $news->views = true;
        } else {
            $news->views = false;
        }
        if(isset($request->likes)) {
            $news->likes = true;
        } else {
            $news->likes = false;
        }
        if(isset($request->comments)) {
            $news->comments = true;
        } else {
            $news->comments = false;
        }
        MyLogingController::addLog('Отредактирована новость '. $news->id, json_encode($news->getDirty()));
        $news->update();

        $tagsId = $request->tagsId;
        $news->tags()->sync($tagsId);

        BlockController::setBlock($request->blocks, $news, true);

        return redirect()->route('admin.news.index');
    }
    public function destroy(News $news){
        MyLogingController::addLog('Удаление новости', json_encode($news));
        $news->delete();
        return redirect()->route('admin.news.index');
    }
    public function restart(News $news){
        MyLogingController::addLog('Статистика Сброшена новость '. $news->id, json_encode($news));
        // $news->update(array('viewsCount' => 0));
        $news->viewsCount = 0;
        $news->save();
        return redirect()->route('admin.news.index');
    }

    public function images(Request $request){
        // dd($request);
        if($request->has('file')) {
            $image = $request->file('file');
            // $imageBuffer = file_get_contents($image->getPathname());
            // $compressed = MyService::compress($imageBuffer, 'fit', $request->x, $request->y);
            $meth = isset($request->meth) ? $request->meth : 'fit';
            Log::info(intval($request->x)."|". intval($request->y)."|".$meth);
            $imageBuffer = file_get_contents($image->getPathname());
            $compressed = MyService::compress($imageBuffer, $meth, intval($request->x), intval($request->y));
            if($request->andthumb){
                Log::info(intval($request->x2)."|". intval($request->y2)."|".$meth);
                $compressed2 = MyService::compress($imageBuffer, $meth, intval($request->x2), intval($request->y2));
                $newFileName2 = time() . '_thumb_' . $image->getClientOriginalName();
            }
            $newFileName = time() . '_' . $image->getClientOriginalName();
            if($request->type == 1){
                File::ensureDirectoryExists(public_path('images'));
                File::ensureDirectoryExists(public_path('images/articles'));
                $pp = ('image/articles');
            } else if($request->type == 2){
                File::ensureDirectoryExists(public_path('images'));
                File::ensureDirectoryExists(public_path('images/stories'));
                $pp = ('image/stories');
            }
            else{
                File::ensureDirectoryExists(public_path('images'));
                File::ensureDirectoryExists(public_path('images/news'));
                $pp = ('image/news');
            }
            // $imgUrl = public_path($pp) . '/' . $newFileName;
            $imgUrl =  ''.($pp) . '/' . $newFileName;
            // $result = file_put_contents($imgUrl, $compressed);
            $result = Storage::disk('public_uploads')->put($imgUrl, $compressed);
            // dd($imgUrl, $result);
            // try {
            //     $result = Storage::disk('public_uploads')->put($imgUrl, $compressed);

            //     if (!$result) {
            //         throw new \Exception('Failed to write file to disk.');
            //     }

            //     return response()->json(['message' => 'File saved successfully.']);
            // } catch (\Exception $e) {
            //     \Log::error('File save error: ' . $e->getMessage());
            //     return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
            // }
            // $disk = Storage::disk('public');
            // $disk->put($imgUrl, $compressed);
            // Storage::put($imgUrl, $compressed);
            if($request->andthumb){
                // $imgUrl = public_path($pp) . '/' . $newFileName2;
                $imgUrl = ($pp) . '/' . $newFileName2;
                // file_put_contents($imgUrl, $compressed2);
                Storage::disk('public_uploads')->put($imgUrl, $compressed2);
                // $disk = Storage::disk('public');
                // $disk->put($imgUrl, $compressed2);
                // Storage::put($imgUrl, $compressed2);
            }

            if($request->type == 1)
                $first = '/image/articles/' . $newFileName;
            else if($request->type == 2)
                $first = '/image/stories/' . $newFileName;
            else
                $first  = '/image/news/' . $newFileName;
            if($request->andthumb){
                if($request->type == 1)
                    $second = '/image/articles/' . $newFileName2;
                else if($request->type == 2)
                    $second = '/image/stories/' . $newFileName2;
                else
                    $second  = '/image/news/' . $newFileName2;
            }
            if($request->andthumb)
                return response()->json(['first' => $first, 'second' => $second]);
            else
                return response()->json(['first' => $first]);
        }else {

        }
    }

    public function allNews(){
        $settings = Setting::where('key', 'all-news')->first();
        if(!$settings){
            $settings = new Setting();
        }
        $settings = json_decode($settings->content, true);
        if(!$settings){
            $settings = [];
        }
        $news = News::where('type', '0')->orderBy('created_at', 'desc')->limit(5)->get();
        $news5Ids = [];
        foreach ($news as $nw) {
            $news5Ids[] = $nw->id;
        }

        $allNews = News::where('type', '0')->whereNotIn('id', $news5Ids)->orderBy('created_at', 'desc')->paginate(9);
        // $user = auth()->user();
        // $likedNewsIds = $user ? Favorite::where('user_id', $user->id) : [];

        $tags = Tag::where('type','1')->get();
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
        // $allTags = Tag::where('type', '0')->get();
        // $allHotels = Hotel::all();
        return view('pages.news', compact('settings', 'news', 'allNews', 'tags', 'article'));
    }

    public function allNewsSort(Request $request){
        $news5Ids = News::where('type', '0')->orderBy('created_at', 'desc')->limit(5)->pluck('id')->toArray();
        $news = News::where('type', '0')->whereNotIn('id', $news5Ids);
        if($request->tagId){
            $tag = Tag::where('id', $request->tagId)->firstOrFail();
            $newsByTags = NewsTag::where('tag_id', $tag->id)->pluck('news_id')->toArray();
            $news->whereIn('id', $newsByTags);
        }
        $news = $news->orderBy('created_at', 'desc')->paginate(9)->withQueryString();
        $list = $news->items();
        $hasMorePages = $news->hasMorePages();
        // $list = view('parts.hub-hotel-items', ['hotels' => $blockHotels])
        $render = View::make('parts.hub-hotel-items', [ 'hotels' =>  $news])->render();
        return response()->json(['status' => 200, 'list' => $render, 'hasMorePages' => $hasMorePages]);
    }

    public function allarticle(){
        $settings = Setting::where('key', 'all-article')->first();
        if(!$settings){
            $settings = new Setting();
        }
        $settings = json_decode($settings->content, true);
        if(!$settings){
            $settings = [];
        }
        $news5 = News::where('type', '0')->orderBy('created_at', 'desc')->limit(5)->get();
        $news5Ids = [];
        foreach ($news5 as $nw) {
            $news5Ids[] = $nw->id;
        }

        $allNews = News::where('type', '0')->whereNotIn('id', $news5Ids)->orderBy('created_at', 'desc')->paginate(9);
        // $user = auth()->user();
        // $likedNewsIds = $user ? Favorite::where('user_id', $user->id) : [];

        $tags = Tag::where('type',1)->get();
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
        // $allTags = Tag::where('type', '0')->get();
        // $allHotels = Hotel::all();
        return view('pages.articles', compact('settings', 'news', 'allNews', 'tags', 'article'));
    }
}
