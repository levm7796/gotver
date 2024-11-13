<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CurrentImg;
use App\Models\Hotel;
use App\Models\HotelTags;
use App\Models\Hub;
use App\Models\Images;
use App\Models\Location;
use App\Models\News;
use App\Models\Tag;
use App\Services\MyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Locale;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $query = Location::query();
        if ($request->has('name') && $request->input('name') != '') {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('s') && $request->has('d')) {
            $sort = $request->input('s');
            $direction = $request->input('d') == 'asc' ? 'asc' : 'desc';
            $query->orderBy($sort, $direction);
        }
        $locations = $query->paginate(15)->withQueryString();
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        $svgs = MyService::getSvg();
        return view('admin.locations.add', compact('svgs'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'putevoditel_po' => 'required|max:255',
            'imgs' => 'required',
            'icon' => 'required|max:255',
            'seo_text' => 'required|max:5000',
            'order' => 'integer|min:0',
        ]);
        $location = new Location();
        $location->name = $request->name;
        $location->putevoditel_po = $request->putevoditel_po;
        $location->icon = $request->icon;
        $location->seo_text = $request->seo_text;
        $location->btn_text = $request->btn_text;
        $location->order = $request->order;

//        $location->title1 = 'Спланируйте своё идеальное путешествие';
//        $location->description1 = 'В рамках спецификации современных стандартов, акционеры крупнейших компаний освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы, разумеется, в равной степени предоставлены сами себе.';
//        $location->title2 = 'Теги, которые чаще всего ищут';
//        $location->description2 = 'В рамках спецификации современных стандартов, акционеры крупнейших компаний освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы, разумеется, в равной степени предоставлены сами себе.';
        MyLogingController::addLog('Добовалена локация', json_encode($location));
        $location->save();

        $currentImg = CurrentImg::query()->pluck('img')->toArray();
        $imgs = explode(',', $request->imgs);
        $diffImage = array_diff($currentImg, $imgs);
        $file_path = public_path('images/');
        foreach ($diffImage as $img) {
            CurrentImg::where('img', $img)->delete();
            File::delete($file_path . $img);
        }

        foreach ($imgs as $index => $item) {
            $img = New Images();
            $img->img = $imgs[$index];
            $img->table = $location->getTable();
            $img->table_id = $location->id;
            $img->save();
        }

        CurrentImg::query()->truncate();

        return redirect()->route('admin.locations.index');
    }

    public function edit(Location $location)
    {
        $svgs = MyService::getSvg();
        $hubs = Hub::where('location_id', $location->id)->get();
        $articles = News::where('type', '2')->orderBy('created_at', 'desc')->get();
        $imgs = Images::where('table', 'locations')->where('table_id', $location->id)->pluck('img')->toArray();
        $tags = Tag::all();
        return view('admin.locations.edit', compact('location', 'svgs', 'hubs', 'articles', 'imgs', 'tags'));
    }

    public function update(Request $request, Location $location){
        $this->validate($request, [
            'name' => 'required|max:255',
            'putevoditel_po' => 'required|max:255',
            'icon' => 'required|max:255',
            'seo_text' => 'required|max:5000',
            'order' => 'integer|min:0',
        ]);

        $currentImg = CurrentImg::query()->pluck('img')->toArray();
        $imgs = explode(',', $request->imgs);
        $diffImage = array_diff($currentImg, $imgs);
        $file_path = public_path('images/');
        $oldImages = explode(',', $request->oldImgs);
        foreach ($diffImage as $img) {
            if(empty(in_array($img, $oldImages))) {
                CurrentImg::where('img', $img)->delete();
                File::delete($file_path . $img);
            }
        }

        $location->name = $request->name;
        $location->putevoditel_po = $request->putevoditel_po;
        $location->icon = $request->icon;
        $location->seo_text = $request->seo_text;
        $location->btn_text = $request->btn_text;
        $location->order = $request->order;
        MyLogingController::addLog('Отредактирована локация', json_encode($location->getDirty()));
        $location->save();

        $data = [];
        $data['title'] = $request->title;
        $data['autoplay'] = $request->autoplay;
        $data['description'] = $request->description;
        $data['h1'] = $request->h1;
        $data['article_id'] = $request->article_id;
        $data['article_text'] = $request->article_text;
        // dd($request->hubs);
        $data['hubs'] = $request->hubs;
        $data['main_hubs'] = $request->main_hubs;
        $data['menu_links'] = $request->menu_links;
        $data['additional_tags_add'] = $request->additional_tags_add;
        $data['additional_tags_remove'] = $request->additional_tags_remove;
        $data['titleTravel'] = $request->titleTravel;
        $data['descriptionTravel'] = $request->descriptionTravel;
        $data['titleTags'] = $request->titleTags;
        $data['descriptionTags'] = $request->descriptionTags;
        $location->setContent($data);

        Images::where('table', 'locations')->where('table_id', $location->id)->delete();
        foreach ($imgs as $index => $item) {
            $img = New Images();
            $img->img = $imgs[$index];
            $img->table = $location->getTable();
            $img->table_id = $location->id;
            $img->save();
        }

        CurrentImg::query()->truncate();

        return redirect()->route('admin.locations.index');
    }

    public function destroy(Request $request, Location $location){
        MyLogingController::addLog('Локация удалена', json_encode($location));
        $location->delete();

        return redirect()->route('admin.locations.index');
    }

    public function locationIndex($location){
        $location = Location::where('id', $location)->first();
        if(!$location)
            abort(404);
        $settings = $location->getContent();

        $tags = $location->getAllTagsBySettings();


        $hotelsId = $location->hotels->pluck('id')->toArray();
        $tagsId = HotelTags::whereIn('hotel_id', $hotelsId)->get()->pluck('tag_id')->toArray();
        $uniqueTagIds = array_unique($tagsId);
        $uniqueLocationTags = Tag::whereIn('id', $uniqueTagIds)->orderBy('name', 'ASC')->get();
        $ids = optional(optional($uniqueLocationTags)[0])->id ?? [];
        $hotelsIdByFirstTag = HotelTags::where('tag_id', $ids)->pluck('hotel_id')->toArray();
        $selectedHotels = Hotel::whereIn('id', $hotelsIdByFirstTag)->limit(5)->get();
        $ids = is_null(optional($location->getContent())['main_hubs']) ? [] : optional($location->getContent())['main_hubs'];
        $main_hubs = [];//Hub::whereIn('id', $ids)->get();
        foreach ($ids as $hubId) {
            $hub = Hub::where('id', $hubId)->first();
            if($hub){
               $main_hubs[] = $hub;
            }
        }
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

        return view('pages.location', compact('settings', 'main_hubs', 'location', 'tags', 'article', 'uniqueLocationTags', 'selectedHotels'));
    }

    public function locationFilter(Request $request){
        $tagId = $request->tagId;
        $custom_tag = Tag::where('id', $tagId)->with('hotels')->first();
        // $hotelsIdByFirstTag = HotelTags::where('tag_id', $tagId)->pluck('id')->toArray();
        // $selectedHotels = Hotel::whereIn('id', $hotelsIdByFirstTag)->limit(5)->get();
        $render = View::make('parts.location-card-grid-to-slider_instant-items', [ 'hotels' => $custom_tag->hotels->take(5), 'tag' => $custom_tag])->render();
        return response()->json(['status' => 200, 'list' => $render]);
    }


}
