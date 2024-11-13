<?php

namespace App\Http\Controllers;

use App\Models\BlocksNews;
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
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Illuminate\Support\Facades\File;
use stdClass;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        $articles = News::query()->where('type', '1');
        if ($request->has('name') && $request->input('name') != '') {
            $articles->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('location_id') && $request->input('location_id') != '') {
            $articles->where('location_id', $request->input('location_id'));
        }
        if ($request->has('hub_id') && $request->input('hub_id') != '') {
            $articles->where('hub_id', $request->input('hub_id'));
        }
        if ($request->has('activenow') && $request->input('activenow') != '') {
            $articles->where('created_at', '<=', $request->input('activenow'));
            $articles->where('end_date', '>=', $request->input('activenow'))->orWhereNull('end_date');
        }
        if ($request->has('s') && $request->has('d')) {
            $sort = $request->input('s');
            $direction = $request->input('d') == 'asc' ? 'asc' : 'desc';
            $articles->orderBy($sort, $direction);
        }
        $locations = Location::all();
        $hubs = Hub::all();
        $articles = $articles->paginate(15)->withQueryString();
        return view('admin.articles.index', compact('articles', 'locations', 'hubs'));
    }

    public function anonsIndex(Request $request){
        $articles = News::query()->where('type', '2');
        $locations = Location::all();
        $hubs = Hub::all();
        $articles = $articles->paginate(15)->withQueryString();
        return view('admin.anonses.index', compact('articles', 'locations', 'hubs'));
    }

    public function create()
    {
        $allTags = Tag::query()->where('type', '0')->get();
        $locations = Location::all();
        $hubs = Hub::all();
        return view('admin.articles.add', compact('allTags', 'locations', 'hubs'));
    }

    public function anonsCreate()
    {
        $allTags = Tag::query()->where('type', '0')->get();
        $locations = Location::all();
        $hubs = Hub::all();
        return view('admin.anonses.add', compact('allTags', 'locations', 'hubs'));
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

        // $fileArr = MyService::compressImg('img', $request, false);
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
        $news->type = '1';
        $news->end_date = $request->end_date;
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
        $news->save();
        MyLogingController::addLog('Добовалена статья '.$news->id, json_encode($news));

        BlockController::setBlock($request->blocks, $news, false);

        $tagsId = $request->tagsId;
        $news->tags()->sync($tagsId);

        return redirect()->route('admin.articles.index');
    }

    public function anonsStore(Request $request)
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

        // $fileArr = MyService::compressImg('img', $request, false);
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
        $news->type = '2';
        $news->end_date = $request->end_date;
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
        $news->save();
        MyLogingController::addLog('Добовален анонс '.$news->id, json_encode($news));

        BlockController::setBlock($request->blocks, $news, false);

        $tagsId = $request->tagsId;
        $news->tags()->sync($tagsId);

        return redirect()->route('admin.anonses.index');
    }
    public function edit( $news)
    {
        $news = News::withoutGlobalScope('active')->where('id', $news)->first();

        foreach ($news->blocks as $block) {
            $blocks[] = json_decode($block, true);
        }
        if(!isset($blocks[0])) {
            $blocks = null;
        }

        $allTags = Tag::query()->where('type', '0')->get();

        $locations = Location::all();
        $hubs = Hub::all();
        $author = User::findOrFail($news->author)->pluck('name')->toArray()[0];
        return view('admin.articles.edit', compact('news', 'blocks', 'allTags', 'author', 'locations', 'hubs'));
    }
    public function anonsEdit( $news)
    {
        $news = News::withoutGlobalScope('active')->where('id', $news)->first();

        foreach ($news->blocks as $block) {
            $blocks[] = json_decode($block, true);
        }
        if(!isset($blocks[0])) {
            $blocks = null;
        }

        $allTags = Tag::query()->where('type', '0')->get();

        $locations = Location::all();
        $hubs = Hub::all();
        $author = User::findOrFail($news->author)->pluck('name')->toArray()[0];
        return view('admin.anonses.edit', compact('news', 'blocks', 'allTags', 'author', 'locations', 'hubs'));
    }
    public function update(Request $request, $news) {
        $news = News::withoutGlobalScope('active')->where('id', $news)->first();

        $this->validate($request, [
            'location_id' => 'required|exists:locations,id',
            'hub_id' => 'required|exists:hubs,id',
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'tagsId.*' => 'exists:tags,id',
            'description' => 'string|max:5000',
            'coordinates' => 'max:255',
            'signature' => 'max:255',
            'order' => 'integer|min:0',
        ]);

        // check if directory exist
        File::ensureDirectoryExists(public_path('images'));


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
        $news->end_date = $request->end_date;
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
        MyLogingController::addLog('Отредактирован статья '.$news->id, json_encode($news->getDirty()));
        $news->update();

        $tagsId = $request->tagsId;
        $news->tags()->sync($tagsId);

        BlockController::setBlock($request->blocks, $news, true);

        return redirect()->route('admin.articles.index');
    }
    public function anonsUpdate(Request $request, $news) {
        $news = News::withoutGlobalScope('active')->where('id', $news)->first();

        $this->validate($request, [
            'location_id' => 'required|exists:locations,id',
            'hub_id' => 'required|exists:hubs,id',
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'tagsId.*' => 'exists:tags,id',
            'description' => 'string|max:5000',
            'coordinates' => 'max:255',
            'signature' => 'max:255',
            'order' => 'integer|min:0',
        ]);

        // check if directory exist
        File::ensureDirectoryExists(public_path('images'));


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
        $news->end_date = $request->end_date;
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
        MyLogingController::addLog('Отредактирова анонс '.$news->id, json_encode($news->getDirty()));
        $news->update();

        $tagsId = $request->tagsId;
        $news->tags()->sync($tagsId);

        BlockController::setBlock($request->blocks, $news, true);

        return redirect()->route('admin.anonses.index');
    }
    public function destroy($news){
        $news = News::withoutGlobalScope('active')->where('id', $news)->first();

        MyLogingController::addLog('Удаление статьи', json_encode($news));
        $news->delete();
        return redirect()->route('admin.articles.index');
    }
    public function anonsDestroy($news){
        $news = News::withoutGlobalScope('active')->where('id', $news)->first();

        MyLogingController::addLog('Удаление анонса', json_encode($news));
        $news->delete();
        return redirect()->route('admin.anonses.index');
    }
    public function restart($news){
        $news = News::withoutGlobalScope('active')->where('id', $news)->first();
        MyLogingController::addLog('Сброс статистики статья '. $news->id, json_encode($news));
        // $news->update(array('viewsCount' => 0));
        $news->viewsCount = 0;
        $news->save();
        return redirect()->route('admin.articles.index');
    }

    // public function allArticles(){
    //     $settings = Setting::where('key', 'all-articles')->first();
    //     if(!$settings){
    //         $settings = new Setting();
    //     }
    //     $settings = json_decode($settings->content);
    //     if(!$settings){
    //         $settings = [];
    //     }
    //     return view('pages.articles', compact('settings'));
    // }
}
