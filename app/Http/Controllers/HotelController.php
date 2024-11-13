<?php

namespace App\Http\Controllers;

use App\Models\CurrentImg;
use App\Models\Favorite;
use App\Models\Hotel;
use App\Models\HotelInteraction;
use App\Models\HotelOption;
use App\Models\HotelSocial;
use App\Models\Hub;
use App\Models\Images;
use App\Models\Location;
use App\Models\News;
use App\Models\Option;
use App\Models\Places;
use App\Models\Social;
use App\Models\Tag;
use App\Services\MyService as MyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $hotels = Hotel::query();
        if ($request->has('id') && $request->input('id') != '') {
            $hotels->where('id', $request->input('id'));
        }
        if ($request->has('name') && $request->input('name') != '') {
            $hotels->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('location_id') && $request->input('location_id') != '') {
            $hotels->where('location_id', $request->input('location_id'));
        }
        if ($request->has('hub_id') && $request->input('hub_id') != '') {
            $hotels->where('hub_id', $request->input('hub_id'));
        }
        if ($request->has('activenow') && $request->input('activenow') != '') {
            $hotels->where('created_at', '<=', $request->input('activenow'));
            $hotels->where('end_date', '>=', $request->input('activenow'))->orWhereNull('end_date');
        }

        if ($request->has('s') && $request->has('d')) {
            $sort = $request->input('s');
            $direction = $request->input('d') == 'asc' ? 'asc' : 'desc';
            $hotels->orderBy($sort, $direction);
        }
        $locations = Location::all();
        $hubs = Hub::orderBy('location_id', 'asc')->get();
        $hotels = $hotels->withoutGlobalScope('active')->paginate(15)->withQueryString();

        return view('admin.hotels.index', compact('hotels', 'locations', 'hubs'));
    }
    public function create()
    {
        $spritePath = public_path('/img/sprite.svg');
        $spriteContent = File::get($spritePath);
        preg_match_all('/<symbol\s+id="([^"]+)"/', $spriteContent, $matches);
        $symbolIds = $matches[1];
        $svgs = $symbolIds;

        $records = Social::query()->select('icon')->get()->toArray();
        $socialSvgs = [];
        foreach ($records as $record) {
            array_push($socialSvgs, $record['icon']);
        }

        $options = Option::query()->get()->toArray();

        $locations = Location::all();
        $hubs = Hub::all();
        $tags = Tag::query()->where('type', '0')->get();


        return view('admin.hotels.add', compact('svgs', 'options', 'socialSvgs', 'locations', 'hubs', 'tags'));
    }

    public function store(Request $request) {
//        dd($request->all());
        $this->validate($request, [
            'location_id' => 'required|exists:locations,id',
            'hub_id' => 'required|exists:hubs,id',
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'imgs' => 'required',
            'price' => 'required',
            'tagsId.*' => 'exists:tags,id',
            'optionIds.*' => 'exists:options,id',
            'description' => 'string|max:5000',
            'coordinates' => 'max:255',
            'address' => 'max:255',
            'order' => 'min:0',
            'email' => 'email',
            'phone' => 'string|min:18'
        ]);

        // $socialArr = MyService::getArray(['socialIcon', 'social'], $request->all());
        // $placesArr = MyService::getArray(['icon', 'places'], $request->all());

        $currentImg = CurrentImg::query()->pluck('img')->toArray();
        $imgs1 = explode(',', $request->imgs);
        $diffImage = array_diff($currentImg, $imgs1);
        foreach ($diffImage as $img) {
            CurrentImg::where('img', $img)->delete();
            $file = public_path('images/'.$img);
            if(file_exists($file)) {
                unlink($file);
            }
        }

        $imgs = [];

        foreach ($imgs1 as $index => $item) {
            $imgs[$index]['img'] = $item;
            $thumb = CurrentImg::where('img', $item)->pluck('thumb_img')->toArray();
            if(count($thumb) !== 0) {
                $imgs[$index]['thumb'] = $thumb[0];
            } else {
                $imgs[$index]['thumb'] = Images::where('img', $item)->pluck('thumb_img')->toArray()[0];
            }
        }

        $phone = ltrim($request->phone, '+');
        $phone = preg_replace('/\D/', '', $phone);

        $hotel = New Hotel();
        $hotel->location_id = $request->location_id;
        $hotel->hub_id = $request->hub_id;
        $hotel->name = $request->name;
        $hotel->contact_description = $request->contact_description;
        $hotel->title = $request->title;
        $hotels->seo_text = $request->seo_text;
        $hotel->description = $request->description;
        $hotel->address = $request->address;
        $hotel->coordinates = isset($request->coordinates) ? $request->coordinates : '';
        $hotel->email = $request->email;
        $hotel->reservation = isset($request->reservation) ? $request->reservation : '';
        $hotel->number = $phone;
        $hotel->website = $request->website;
        $hotel->price = $request->price;
        $hotel->order = $request->order;
        if($request->views == 1) {
            $hotel->views = true;
        } else {
            $hotel->views = false;
        }
        if($request->likes == 1) {
            $hotel->likes = true;
        } else {
            $hotel->likes = false;
        }
        if($request->comments == 1) {
            $hotel->comments = true;
        } else {
            $hotel->comments = false;
        }
        $hotel->save();


        $places = [];
        foreach (json_decode($request->places, true) as $index => $arr) {
            if(isset($placesArr[$index]['places'])) {
                $places[$index] = new Places();
                $places[$index]->icon = $arr['icon'];
                $places[$index]->text = $arr['places'];
                $places[$index]->hotels_id = $hotel->id;
                $places[$index]->save();
            }
        }

        $social = [];

        foreach (json_decode($request->social, true) as $index => $arr) {
            if(isset($arr['social'])) {
                $social[$index] = new HotelSocial();
                $social[$index]->icon = $arr['icon'];
                $social[$index]->link = $arr['place'];
                $social[$index]->hotels_id = $hotel->id;
                $social[$index]->save();
            }
        }


        foreach ($imgs as $index => $item) {
            $img = New Images();
            $img->img = $imgs[$index]['img'];
            $img->thumb_img = $imgs[$index]['thumb'];
            $img->table = $hotel->getTable();
            $img->table_id = $hotel->id;
            $img->save();
        }

        $tagsId = $request->tagsId;
        $hotel->tags()->sync($tagsId);
        // $hotel->places()->saveMany($places);
        // $hotel->social()->saveMany($social);
        $hotel->options()->sync($request->optionIds);
        CurrentImg::query()->truncate();

        return redirect()->route('admin.hotels.index');
    }
    public function images(Request $request) {
        $img = New CurrentImg;
        if($request->file('file') !== null) {
            if($request->type == 'location'){
                $fileArr = MyService::compressImg($request->file('file'), $request, false, 1068, 480);
            } else if($request->type == 'hotel'){
                $fileArr = MyService::compressImg($request->file('file'), $request, false, 456, 278);
            } else {
                $fileArr = MyService::compressImg($request->file('file'), $request, false);
            }
            $img->img = '/images/'.$fileArr['newFileName'];
            $img->save();
            return '/images/'.$fileArr['newFileName'];
        } else {
            $img->img = $request->file;
            $img->save();
            return $request->file;
        }
    }

    public function deleteImages() {
        CurrentImg::query()->truncate();
    }

    public function edit($hotels) {
        $hotels = Hotel::withoutGlobalScope('active')->where('id', $hotels)->first();
        $spritePath = public_path('/img/sprite.svg');
        $spriteContent = File::get($spritePath);
        preg_match_all('/<symbol\s+id="([^"]+)"/', $spriteContent, $matches);
        $symbolIds = $matches[1];
        $svgs = $symbolIds;

        $records = Option::query()->get()->toArray();
        foreach ($hotels->options as $option) {
            $options['oldOption'][] = $option->id;
        }
        $options['allOption'] = $records;

        $records = Social::query()->select('icon')->get()->toArray();
        $socialSvgs = [];
        foreach ($records as $record) {
            array_push($socialSvgs, $record['icon']);
        }

        $social = $hotels->social;

        $imgs = Images::where('table', 'hotels')->where('table_id', $hotels->id)->pluck('img')->toArray();

        $places = $hotels->places;

        $locations = Location::all();
        $hubs = Hub::all();
        $allTags = Tag::where('type', '0')->get();

        return view('admin.hotels.edit', compact('hotels', 'svgs', 'options', 'imgs', 'places', 'socialSvgs', 'social', 'locations', 'hubs', 'allTags'));
    }
    public function update(Request $request, $hotels) {
        $hotels = Hotel::withoutGlobalScope('active')->where('id', $hotels)->first();
        $this->validate($request, [
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'imgs' => 'required',
            'price' => 'required',
            'optionIds.*' => 'exists:options,id',
            'description' => 'string|max:5000',
            'coordinates' => 'max:255',
            'address' => 'max:255',
            'order' => 'integer|min:0',
            'email' => 'email',
            'phone' => 'string|min:18'
        ]);

        // $socialArr = MyService::getArray(['socialIcon', 'social'], $request->all());
        // $placesArr = MyService::getArray(['icon', 'places'], $request->all());

        $currentImg = CurrentImg::query()->pluck('img')->toArray();
        $imgs1 = explode(',', $request->imgs);
        $diffImage = array_diff($currentImg, $imgs1);
        $file_path = public_path('images/');
        $oldImages = explode(',', $request->oldImgs);
        foreach ($diffImage as $index => $img) {
            if(empty(in_array($img, $oldImages))) {
                $file = public_path('images/'.$img);
                if(file_exists($file) && is_file($thumbFile)) {
                    unlink($file);
                }
                $thumbFile = public_path('images/'.CurrentImg::where('img', $img)->pluck('thumb_img')->toArray()[0]);
                if(file_exists($thumbFile) && is_file($thumbFile)) {
                    try{
                        unlink($thumbFile);
                    } catch (Throwable $e){

                    }
                }
                CurrentImg::where('img', $img)->delete();
            }
        }
        $imgs = [];

        foreach ($imgs1 as $index => $item) {
            $imgs[$index]['img'] = $item;
            $thumb = CurrentImg::where('img', $item)->pluck('thumb_img')->toArray();
            if(count($thumb) !== 0) {
                $imgs[$index]['thumb'] = $thumb[0];
            } else {
                $imgs[$index]['thumb'] = Images::where('img', $item)->pluck('thumb_img')->toArray()[0];
            }
        }

        $phone = ltrim($request->phone, '+');
        $phone = preg_replace('/\D/', '', $phone);

        $hotels->location_id = $request->location_id;
        $hotels->hub_id = $request->hub_id;
        $hotels->name = $request->name;
        $hotels->title = $request->title;
        $hotels->address = $request->address;
        $hotels->description = $request->description;
        $hotels->coordinates = isset($request->coordinates) ? $request->coordinates : '';
        $hotels->reservation = isset($request->reservation) ? $request->reservation : '';
        $hotels->contact_description = $request->contact_description;
        $hotels->seo_text = $request->seo_text;
        $hotels->email = $request->email;
        $hotels->number = $phone;
        $hotels->website = $request->website;
        $hotels->price = $request->price;
        $hotels->order = $request->order;
        if(isset($request->views)) {
            $hotels->views = true;
        } else {
            $hotels->views = false;
        }
        if(isset($request->likes)) {
            $hotels->likes = true;
        } else {
            $hotels->likes = false;
        }
        if(isset($request->comments)) {
            $hotels->comments = true;
        } else {
            $hotels->comments = false;
        }
        $hotels->update();


        $places = [];
        Places::where('hotels_id', $hotels->id)->delete();
        foreach (json_decode($request->places, true) as $index => $arr) {
            // if(isset($placesArr[$index]['places'])) {
                $places[$index] = new Places();
                $places[$index]->icon = $arr['icon'];
                $places[$index]->text = $arr['place'];
                $places[$index]->hotels_id = $hotels->id;
                $places[$index]->save();
            // }
        }

        $social = [];
        HotelSocial::where('hotels_id', $hotels->id)->delete();
        foreach (json_decode($request->social, true) as $index => $arr) {
            // if(isset($arr['social'])) {
            // dd($arr);
                $sc = new HotelSocial();
                $sc->icon = empty($arr['icon']) ? '' : $arr['icon'];
                $sc->link = empty($arr['place']) ? '' : $arr['place'];
                $sc->hotels_id = $hotels->id;
                $sc->save();
            // }
        }
        Images::where('table', 'hotels')->where('table_id', $hotels->id)->delete();
        foreach ($imgs as $index => $item) {
            $img = New Images();
            $img->img = $imgs[$index]['img'];
            $img->thumb_img = $imgs[$index]['thumb'];
            $img->table = $hotels->getTable();
            $img->table_id = $hotels->id;
            $img->save();
        }


        HotelOption::where('hotel_id', $hotels->id)->delete();
        $tagsId = $request->tagsId;
        $hotels->tags()->sync($tagsId);
        // $hotels->places()->saveMany($places);
        // $hotels->social()->saveMany($social);
        $hotels->options()->sync($request->optionIds);
        CurrentImg::query()->truncate();
        return redirect()->route('admin.hotels.index');
    }
    public function restart($id) {
        $hotel = Hotel::where('id', $id)->first();
        MyLogingController::addLog('Статистика Сброшена отэль '. $hotel->id, json_encode($hotel));
        // $hotel->update(array('viewsCount' => 0, 'link_click' => 0, 'phone_click' => 0));
        $hotel->viewsCount = 0;
        $hotel->link_click = 0;
        $hotel->phone_click = 0;
        $hotel->save();
        return redirect()->back();
        return redirect()->route('admin.hotels.index');
        return $id;
    }
    public function destroy($hotels) {
        $hotels = Hotel::withoutGlobalScope('active')->where('id', $hotels)->first();
        $hotels->delete();
        return redirect()->route('admin.hotels.index');
    }
    public function statisticRedirect($hotelId, $redirect){
        $hotel = Hotel::where('id', $hotelId)->first();
        if(!$hotel)
            return redirect()->back();
        $hotel->link_click = intval($hotel->link_click) + 1;
        $hotel->save();
        return redirect(base64_decode($redirect));
    }
    public function statisticPhone($hotelId){
        $hotel = Hotel::where('id', $hotelId)->first();
        if(!$hotel)
            return redirect()->back();
        $hotel->phone_click = intval($hotel->phone_click) + 1;
        $hotel->save();
        return response(403);
    }
    function favorite(Request $request) {
        $userId = Auth::user()->id;
        $tableId = request()->id;
        $table = request()->table;
        if(count(Favorite::where('user_id', $userId)->where('table_name', $table)->where('item_id', $tableId)->get()) == 0) {
            $favorite = New Favorite();
            $favorite->user_id = $userId;
            $favorite->table_name = $table;
            $favorite->item_id = $tableId;
            $favorite->save();
            $news = Hotel::whereId($tableId)->get();
            $oldValue = $news[0]->likesCount;
            Hotel::whereId($tableId)->update(array('likesCount' => $oldValue + 1));
            return true;
        } else {
            Favorite::where('user_id', $userId)->where('table_name', $table)->where('item_id', $tableId)->delete();
            $oldValue = Hotel::whereId($tableId)->select('likesCount')->get();
            $oldValue = $oldValue[0]['likesCount'];
            Hotel::whereId($tableId)->update(array('likesCount' => $oldValue - 1));
            return false;
        }
    }
}
