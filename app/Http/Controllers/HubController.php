<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Hotel;
use App\Models\HotelTags;
use App\Models\newsTag;
use Illuminate\Support\Facades\File;
use App\Models\Hub;
use App\Models\Location;
use App\Models\News;
use App\Models\Tag;
use App\Services\MyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

use function Symfony\Component\String\s;

class HubController extends Controller
{
    public function index(Request $request)
    {
        $hubs = Hub::query();

        if ($request->has('name') && $request->input('name') != '') {
            $hubs->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('location_id') && $request->input('location_id') != '') {
            if($request->input('location_id') == '-1')
                $hubs->whereNull('location_id');
            else
                $hubs->where('location_id', $request->input('location_id'));
        }
        if ($request->has('s') && $request->has('d')) {
            $sort = $request->input('s');
            $direction = $request->input('d') == 'asc' ? 'asc' : 'desc';
            $hubs->orderBy($sort, $direction);
        }
        $locations = Location::all();

        $hubs = $hubs->paginate(15)->withQueryString();
        return view('admin.hubs.index', compact('hubs', 'locations'));
    }

    public function create()
    {
        $locations = Location::all();
        $svgs = $this->getSvg();
        return view('admin.hubs.add', compact('locations', 'svgs'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'location_id' => 'exists:locations,id',//required|
            'icon' => 'required|max:255',
            'seo_text' => 'required|max:5000',
            'order' => 'integer|min:0',
        ]);
        $hub = new Hub();
        $hub->name = $request->name;
        $hub->location_id = $request->location_id;
        $hub->icon = $request->icon;
        $hub->seo_text = $request->seo_text;
        $hub->order = $request->order;
        $hub->save();
        MyLogingController::addLog('Добовалена хабовая '.$hub->id, json_encode($hub));

        return redirect()->route('admin.hubs.index');
    }

    public function edit(Hub $hub)
    {

        $locations = Location::all();
        $svgs = $this->getSvg();
        $articles = News::where('type', '2')->orderBy('created_at', 'desc')->get();
        $tags = Tag::all();
        return view('admin.hubs.edit', compact('hub', 'locations', 'svgs', 'articles', 'tags'));
    }

    public function update(Request $request, Hub $hub){
        $this->validate($request, [
            'name' => 'required|max:255',
            'location_id' => 'exists:locations,id',//required|
            'icon' => 'required|max:255',
            'seo_text' => 'required|max:5000',
            'order' => 'integer|min:0',
        ]);
        $hub->name = $request->name;
        $hub->location_id = $request->location_id;
        $hub->icon = $request->icon;
        $hub->seo_text = $request->seo_text;
        $hub->order = $request->order;
        // File::ensureDirectoryExists(public_path('images'));
        // if($request->img){
        //     if($hub->img && Storage::exists($hub->img)){
        //         Storage::delete(public_path($hub->img));
        //     }

        //     $image = $request->file('img');
        //     $imageBuffer = file_get_contents($image->getPathname());
        //     $compressed = MyService::compress($imageBuffer, 'cover', 235, 350);
        //     $newFileName = time() . "_" . $image->getClientOriginalName();
        //     $pp = public_path('images/hubs/');
        //     $imgUrl = $pp . $newFileName;
        //     file_put_contents($imgUrl, $compressed);
        //     $hub->img = '/images/category/' . $newFileName;
        // }
        MyLogingController::addLog('Отредактирована хабовая '.$hub->id, json_encode($hub->getDirty()));
        $hub->save();
        $data = $hub->getContent();
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['article_id'] = $request->article_id;
        $data['block_logic'] = $request->block_logic;
        $data['article_text'] = $request->article_text;
        $data['h1'] = $request->h1;
        $data['hubs'] = $request->hubs;
        $data['additional_tags_add'] = $request->additional_tags_add;
        $data['additional_tags_remove'] = $request->additional_tags_remove;
        $data['titleTags'] = $request->titleTags;
        $data['titleAlso'] = $request->titleAlso;
        $data['img'] = $request->img;
        // File::ensureDirectoryExists(public_path('images'));
        // File::ensureDirectoryExists(public_path('images/hubs'));
        // if($request->img){

        //     if(optional($data)['img'] && Storage::exists($data['img'])){
        //         Storage::delete(public_path($data['img']));
        //     }

        //     $image = $request->file('img');
        //     $imageBuffer = file_get_contents($image->getPathname());
        //     $compressed = MyService::compress($imageBuffer, 'fit', 219, 320);
        //     $newFileName = time() . '_' . $image->getClientOriginalName();
        //     $pp = public_path('images/hubs');
        //     $imgUrl = $pp . '/' . $newFileName;
        //     file_put_contents($imgUrl, $compressed);
        //     $data['img'] = '/images/hubs/' . $newFileName;
        // }

        $hub->setContent($data);

        return redirect()->route('admin.hubs.index');
    }

    public function destroy(Hub $hub)
    {
        MyLogingController::addLog('Удаление хабовой', json_encode($hub));
        $hub->delete();
        return redirect()->route('admin.hubs.index');
    }

    public function hubIndex( $hub){
        $hub = Hub::where('id', $hub)->first();
        if(!$hub){
            abort(404);
        }
        $settings = $hub->getContent();
        if(!isset($settings['block_logic'])){
            $settings['block_logic'] = 0;
        }
        $tags = $hub->getAllTagsBySettings();

        switch($settings['block_logic']){
            case 0:
            case '0':
                $hotelsId = $hub->hotels->pluck('id')->toArray();
                $tagsId = HotelTags::whereIn('hotel_id', $hotelsId)->get()->pluck('tag_id')->toArray();
                $uniqueTagIds = array_unique($tagsId);
                $uniqueHotelsTags = Tag::whereIn('id', $uniqueTagIds)->get();

                $articles = $hub->articles(5);//News::where('type', '1')->where('hub_id', $hub->id)->orderBy('created_at','desc')->limit(5)->get();
                break;
            case 1:
            case '1':
                $hotelsId = $hub->articles->pluck('id')->toArray();
                $tagsId = newsTag::whereIn('news_id', $hotelsId)->get()->pluck('tag_id')->toArray();
                $uniqueTagIds = array_unique($tagsId);
                $uniqueHotelsTags = Tag::whereIn('id', $uniqueTagIds)->get();

                $articles = Hotel::where('hub_id', $hub->id)->orderBy('created_at','desc')->limit(5)->get();
                break;
            case 2:
            case '2':
                $hotelsId = $hub->articles->pluck('id')->toArray();
                $tagsId = newsTag::whereIn('news_id', $hotelsId)->get()->pluck('tag_id')->toArray();
                $uniqueTagIds = array_unique($tagsId);
                $uniqueHotelsTags = Tag::whereIn('id', $uniqueTagIds)->get();

                break;
        }




        $article = [];
        $article['show'] = false;
        if(isset($settings['article_id'])){
            switch($settings['article_id']){
                case -1:
                    $art = News::where('type', '1')->orderBy('created_at', 'desc')->first();
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
                    $art = News::where('type', '1')->where('id', $settings['article_id'])->first();
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

        return view('pages.hub', compact('settings', 'hub', 'tags', 'article', 'articles', 'uniqueHotelsTags'));
    }

    function getSvg(){
        $spritePath = public_path('/img/sprite.svg');
        $spriteContent = File::get($spritePath);
        preg_match_all('/<symbol\s+id="([^"]+)"/', $spriteContent, $matches);
        $symbolIds = $matches[1];
        return $symbolIds;
    }

    function hubSort(Request $request) {
        // dd($request);
        $filterState = is_null($request->filterState) ? 1 : $request->filterState;
        $tagId = $request->tagId;
        $hubId = $request->hubId;
        // $tag = Tag::whereId()
        $hotels = Hotel::query();
        if($hubId){
            $hotels->where('hub_id', $hubId);
        }
        if($tagId){
            $hotelsId = HotelTags::where('tag_id', $tagId)->get()->pluck('hotel_id')->toArray();
            $hotels->whereIn('id', $hotelsId);
        }
        switch ($filterState) {
            case 1:
                $hotels = $hotels->orderBy('created_at', 'DESC')->get();
                break;
            case -4:

                // for($i=1; $i<=100; $i++) {
                //     $records = Favorite::where('table_name', 'hotels')->where('item_id', $i)->select('id', 'user_id', 'item_id')->get()->toArray();
                //     if(count($records) !== 0) {
                //         $favorites[$i] = $records;
                //     }
                //     $favorites[$i]['id'] = $i;
                // }
                // rsort($favorites);

                // $hotelsSort = [];

                // foreach ($favorites as $favorite) {
                //     $records = $hotels->whereId($favorite['id'])->get()->toArray();
                //     $hotelsSort[] = $records[0];
                // }
                // return $hotelsSort;
                break;
            case 2:
                $hotels = $hotels->orderBy('price', 'ASC')->get();
                break;
            case 3:
                $hotels = $hotels->orderBy('price', 'DESC')->get();
                break;
            case 4:
                $hotels = $hotels->orderBy('likesCount', 'DESC')->get();
                break;
            case 5:
                $hotels = $hotels->orderBy('commentsCount', 'DESC')->get();
                break;
            case 6:
                $hotels = $hotels->orderBy('viewsCount', 'DESC')->get();
                break;
            default:
                $hotels = $hotels->orderBy('created_at', 'DESC')->get();
                break;
            // case 4:
            //     if($mode) {
            //         $hubs = $hotels->orderBy('viewsCount', 'DESC')->get();
            //     } else {
            //         $hubs = $hotels->orderBy('viewsCount', 'ASC')->get();
            //     }
            //     return $hubs;
        }
        // dd($hotels->get());
        $customTag = Tag::where('id', $tagId)->first();
        $render = View::make('parts.hub-hotel-items', [ 'hotels' => $hotels, 'custom_tag' => $customTag])->render();
        return response()->json(['status' => 200, 'list' => $render]);
    }

    function hubSort2(Request $request) {
        // dd($request);
        $filterState = is_null($request->filterState) ? 1 : $request->filterState;
        $tagId = $request->tagId;
        $hubId = $request->hubId;
        // $tag = Tag::whereId()
        $hotels = News::where('type', '1');
        if($hubId){
            $hotels->where('hub_id', $hubId);
        }
        if($tagId){
            $hotelsId = HotelTags::where('tag_id', $tagId)->get()->pluck('hotel_id')->toArray();
            $hotels->whereIn('id', $hotelsId);
        }
        switch ($filterState) {
            case 1:
                $hotels = $hotels->orderBy('created_at', 'DESC')->get();
                break;
            case -4:

                // for($i=1; $i<=100; $i++) {
                //     $records = Favorite::where('table_name', 'hotels')->where('item_id', $i)->select('id', 'user_id', 'item_id')->get()->toArray();
                //     if(count($records) !== 0) {
                //         $favorites[$i] = $records;
                //     }
                //     $favorites[$i]['id'] = $i;
                // }
                // rsort($favorites);

                // $hotelsSort = [];

                // foreach ($favorites as $favorite) {
                //     $records = $hotels->whereId($favorite['id'])->get()->toArray();
                //     $hotelsSort[] = $records[0];
                // }
                // return $hotelsSort;
                break;
            case 2:
                $hotels = $hotels->orderBy('price', 'ASC')->get();
                break;
            case 3:
                $hotels = $hotels->orderBy('price', 'DESC')->get();
                break;
            case 4:
                $hotels = $hotels->orderBy('likesCount', 'DESC')->get();
                break;
            case 5:
                $hotels = $hotels->orderBy('commentsCount', 'DESC')->get();
                break;
            case 6:
                $hotels = $hotels->orderBy('viewsCount', 'DESC')->get();
                break;
            default:
                $hotels = $hotels->orderBy('created_at', 'DESC')->get();
                break;
            // case 4:
            //     if($mode) {
            //         $hubs = $hotels->orderBy('viewsCount', 'DESC')->get();
            //     } else {
            //         $hubs = $hotels->orderBy('viewsCount', 'ASC')->get();
            //     }
            //     return $hubs;
        }
        // dd($hotels->get());
        $customTag = Tag::where('id', $tagId)->first();
        $render = View::make('parts.hub-hotel-items', [ 'hotels' => $hotels, 'custom_tag' => $customTag])->render();
        return response()->json(['status' => 200, 'list' => $render]);
    }
}
