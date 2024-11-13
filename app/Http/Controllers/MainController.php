<?php

namespace App\Http\Controllers;

use App\Models\HomeBlocks;
use App\Models\Hotel;
use App\Models\Hub;
use App\Models\Location;
use App\Models\News;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MainController extends Controller
{
    public function tos(){
        $tos = Setting::where('key', 'tos')->first();
        if(!$tos){
            $tos = new Setting();
        }
        $tos = json_decode($tos->content, true);
        if(!$tos){
            $tos = '';
        }
        return view('pages.tos', compact('tos'));
    }

    public function tac(){
        $tac = Setting::where('key', 'tac')->first();
        if(!$tac){
            $tac = new Setting();
        }
        $tac = json_decode($tac->content, true);
        if(!$tac){
            $tac = '';
        }
        return view('pages.tac', compact('tac'));
    }

    public function mainIndex(){
        $settings = Setting::where('key', 'common')->first();
        if(!$settings){
            $settings = new Setting();
        }
        $settings = json_decode($settings->content, true);
        if(!$settings){
            $settings = [];
        }
        // if(!empty($settings['roads'])){
        //     $settings['roads'] = json_decode($settings['roads']);
        // }
        // if(!empty($settings['users'])){
        //     $settings['users'] = json_decode($settings['users']);
        // }
        $lct = Location::orderBy('order', 'asc')->first();
        $articles = News::where('location_id', $lct->id)->where('type', '1')->limit(5)->get();
        $ids = is_null(optional($settings)['main_hubs']) ? [] : optional($settings)['main_hubs'];
        // $main_hubs = Hub::whereIn('id', $ids)->get();
        $main_hubs = [];//Hub::whereIn('id', $ids)->get();
        foreach ($ids as $hubId) {
            $hub = Hub::where('id', $hubId)->first();
            if($hub){
               $main_hubs[] = $hub;
            }
        }
        $articleDescription = optional($settings)['article'];

        $touringDescription = optional($settings)['touring'];

        return view('home', compact('settings', 'main_hubs', 'lct', 'articles', 'touringDescription', 'articleDescription'));
    }

    public function mainIndexLocation($locationId){
        $lct = Location::where('id', $locationId)->first();
        if(!$lct){
            return response()->json(['status' => '404']);
        }
        $settings = Setting::where('key', 'main')->first();
        if(!$settings) {
            $settings = new Setting();
        }
        $settings = json_decode($settings->content, true);
        if(!$settings){
            $settings = [];
        }
        $articles = News::where('location_id', $lct->id)->where('type', '1')->limit(5)->get();
        $ids = is_null(optional($lct->getContent())['main_hubs']) ? [] : optional($lct->getContent())['main_hubs'];
        $main_hubs = Hub::whereIn('id', $ids)->get();
        // dd($locationId, $lct, $lct->selectedHubs());
        $data = [
            "locations" => Location::all(),
            "settings" => $settings,
            "main_hubs" => $main_hubs,
            "lct" => $lct,
            "articles" => $articles,
            "current_location" => $lct,
        ];
        $navigator_location = View::make('blocks.navigator-location', $data)->render();
        // $popular_touring = View::make('blocks.popular-touring', $data)->render();
        $popular_articles = View::make('blocks.popular-articles', $data)->render();
        $tag_search = View::make('blocks.tag-search', $data)->render();
//"popular_touring" => $popular_touring,
        return response()->json(['status' => '200', "navigator_location" => $navigator_location,  'popular_articles' => $popular_articles, 'tag_search' => $tag_search]);
    }

    public function search(Request $request) {
        $value = $request->search;
        $hotels = Hotel::where('name', 'like', '%'.$value.'%')->get()->toArray();
        $news = News::where('name', 'like', '%'.$value.'%')->get()->toArray();
        $hotelImg = [];
        foreach ($hotels as $index => $hotel) {
            $hotelImg[] = Hotel::searchImages($hotel['id']);
        }

        $items = [];


        foreach ($hotels as $hotel) {
            $items[] = $hotel;
        }

        foreach ($news as $item) {
            $items[] = $item;
        }

        function array_sort_by_column(&$arr, $col, $dir) {
            $sort_col = array();
            foreach ($arr as $key => $row) {
                $sort_col[$key] = $row[$col];
            }
            array_multisort($sort_col, $dir, $arr);
        }

        array_sort_by_column($items, 'created_at', SORT_ASC);

        return view('pages.search', compact('items', 'hotelImg'));
    }
}
