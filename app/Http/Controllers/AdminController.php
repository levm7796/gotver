<?php

namespace App\Http\Controllers;

use App\Models\HomeBlocks;
use App\Models\Hotel;
use App\Models\Hub;
use App\Models\Location;
use App\Models\News;
use App\Models\Setting;
use App\Services\MyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function allNews(){
        $settings = Setting::where('key', 'all-news')->first();
        if(!$settings){
            $settings = new Setting();
        }
        $settings = json_decode($settings->content, true);
        if(!$settings){
            $settings = [];
        }
        $articles = News::where('type', '2')->get();
        return view('admin.pages.allNews', compact('settings', 'articles'));
    }

    public function allNewsPost(Request $request){
        $data = [];
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['h1'] = $request->h1;
        $data['seo_text'] = $request->seo_text;
        $data['h2'] = $request->h2;
        $data['seo_text2'] = $request->seo_text2;
        $data['news_carousel'] = $request->news_carousel == '1' ? 1 : 0;
        $data['article_id'] = $request->article_id;
        $settings = Setting::where('key', 'all-news')->first();
        if(!$settings){
            $settings = new Setting();
            $settings->key = "all-news";
        }
        $settings->content = json_encode($data);
        MyLogingController::addLog('Настройки страницы новостей', json_encode($settings->getDirty()));
        $settings->save();
        return redirect()->route('admin.allNews');
    }

    public function allArticles(){
        $settings = Setting::where('key', 'all-articles')->first();
        if(!$settings){
            $settings = new Setting();
        }
        $settings = json_decode($settings->content, true);
        if(!$settings){
            $settings = [];
        }
        $articles = News::where('type', '2')->get();
        return view('admin.pages.allNews', compact('settings', 'articles'));
    }

    public function allArticlesPost(Request $request){
        $data = [];
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['h1'] = $request->h1;
        $data['seo_text'] = $request->seo_text;
        $data['news_carousel'] = $request->news_carousel == '1' ? 1 : 0;
        $data['article_id'] = $request->article_id;
        $settings = Setting::where('key', 'all-articles')->first();
        if(!$settings){
            $settings = new Setting();
            $settings->key = "all-articles";
        }
        $settings->content = json_encode($data);
        MyLogingController::addLog('Настройки страницы статей', json_encode($settings->getDirty()));
        $settings->save();
        return redirect()->route('admin.allArticles');
    }

    public function main(){
        $settings = Setting::where('key', 'main')->first();
        if(!$settings){
            $settings = new Setting();
        }
        $settings = json_decode($settings->content, true);
        if(!$settings){
            $settings = [];
        }
        $svgs = MyService::getSvg();
        return view('admin.pages.main', compact('settings', 'svgs'));
    }

    public function mainPost(Request $request){
        $data = [];
        $data['roads'] = ($request->roads);
        $data['users'] = ($request->users);
        $settings = Setting::where('key', 'main')->first();
        if(!$settings){
            $settings = new Setting();
            $settings->key = "main";
        }
        $settings->content = json_encode($data);
        MyLogingController::addLog('Настройки главной', json_encode($settings->getDirty()));
        $settings->save();
        return redirect()->route('admin.main');
    }

    public function back(){
        $settings = Setting::where('key', 'back')->first();
        if(!$settings){
            $settings = new Setting();
        }
        $settings = json_decode($settings->content, true);
        if(!$settings){
            $settings = [];
        }
        $svgs = MyService::getSvg();
        return view('admin.pages.back', compact('settings'));
    }

    public function backPost(Request $request){
        $data = [];
        $data['mail'] = ($request->mail);
        $data['tinify'] = ($request->tinify);
        $data['users'] = ($request->users);
        $settings = Setting::where('key', 'back')->first();
        if(!$settings){
            $settings = new Setting();
            $settings->key = "back";
        }
        $settings->content = json_encode($data);
        MyLogingController::addLog('Настройки главной', json_encode($settings->getDirty()));
        $settings->save();
        return redirect()->route('admin.back');
    }

    public function genSitemap(){
        $models = [
            Location::all(),
            Hub::all(),
            News::all(),
            Hotel::all(),
        ];

        foreach ($models as $model) {
            foreach ($model as $item) {
                $urls[] = url($item->myUrl());
            }
        }

        $xml = view('sitemap', ['urls' => $urls])->render();

        file_put_contents(public_path('sitemap.xml'), $xml);

        return redirect()->back();
    }

    // public function header(){
    //     $settings = Setting::where('key', 'header')->first();
    //     if(!$settings){
    //         $settings = new Setting();
    //     }
    //     $settings = json_decode($settings->content, true);
    //     if(!$settings){
    //         $settings = [];
    //     }
    //     return view('admin.pages.header', compact('settings'));
    // }

    // public function headerPost(Request $request){
    //     $data = [];
    //     $data['direction'] = $request->direction;
    //     $data['users'] = $request->users;
    //     $settings = Setting::where('key', 'header')->first();
    //     if(!$settings){
    //         $settings = new Setting();
    //         $settings->key = "header";
    //     }
    //     $settings->content = json_encode($data);
    //     MyLogingController::addLog('Настройки хидэра', json_encode($settings->getDirty()));
    //     $settings->save();
    //     return redirect()->route('admin.header');
    // }


    public function common(){
        $settings = Setting::where('key', 'common')->first();
        if(!$settings){
            $settings = new Setting();
        }
        $settings = json_decode($settings->content, true);
        if(!$settings){
            $settings = [];
        }
        $svgs = MyService::getSvg();
        $hubs = Hub::whereNull('location_id')->get();
        return view('admin.pages.common', compact('settings', 'svgs', 'hubs'));
    }

    public function commonPost(Request $request){
        $data = [];
        $data['dzen'] = $request->dzen;
        $data['vk'] = $request->vk;
        $data['tg'] = $request->tg;
        $data['ok'] = $request->ok;
        $data['roads'] = $request->roads;
        $data['users'] = $request->users;
        $data['footer_links'] = $request->footer_links;
        $data['main_hubs'] = $request->main_hubs;
        $data['article'] = $request->article;
        $data['touring'] = $request->touring;
        $settings = Setting::where('key', 'common')->first();
        if(!$settings){
            $settings = new Setting();
            $settings->key = "common";
        }
        $settings->content = json_encode($data);
        MyLogingController::addLog('Настройки обших элементов', json_encode($settings->getDirty()));
        $settings->save();
        return redirect()->route('admin.common');
    }

    public function universal($name){
        $settings = Setting::where('key', $name)->first();
        if(!$settings){
            $settings = new Setting();
            $settings->key = $name;
            $settings->content = "";
            $settings->save();
        }
        $settings = json_decode($settings->content, true);
        if(!$settings){
            $settings = '';
        }
        return view('admin.pages.'.$name, compact('settings'));
    }

    public function universalPost(Request $request, $name){
        $settings = Setting::where('key', $name)->first();
        if(!$settings){
            $settings = new Setting();
            $settings->key = $name;
        }

        $settings->content = json_encode($request->content);
        MyLogingController::addLog('Настройки страницы '.$name, json_encode($settings->getDirty()));
        $settings->save();
        return redirect()->route('admin.universal', $name);
    }

    public function editorUpload(Request $request)
    {
        // dd($request);
        $file = $request->file;
        $imgDirectory = '/images/all/';
        File::ensureDirectoryExists(public_path('images'));
        File::ensureDirectoryExists(public_path('images/all'));
        $imageBuffer = file_get_contents($file->getPathname());
        $newFileName = time() . '_' . $file->getClientOriginalName();
        $pp = public_path('images/all');
        $imgUrl = $pp . '/' . $newFileName;
        file_put_contents($imgUrl, $imageBuffer);
        return response()->json(["link" => $imgDirectory.$newFileName]);
    }

    public function editorDelete(Request $request){
        $fileUrl = $request->input('src');
        $parts = explode('/', $fileUrl);
        $filePathParts = array_slice($parts, 3);
        $filePath = implode('/', $filePathParts);
        if ($filePath) {
            unlink(public_path($filePath));
            return response()->json(['message' => 'File deleted successfully.']);
            // if (Storage::delete(public_path($filePath))) {
            //     return response()->json(['message' => 'File deleted successfully.']);
            // } else {
            //     return response()->json(['message' => 'File not found.'], 404);
            // }
        } else {
            return response()->json(['message' => 'Base URL not found.'], 400);
        }
    }

    public function svgEditor(){
        $spritePath = public_path('/img/sprite.svg');
        $content = File::get($spritePath);
        return view('admin.pages.svgeditor', compact('content'));
    }
    public function svgEditorPost(Request $request){
        $spritePath = public_path('/img/sprite.svg');
        $newContent = $request->input('content');
        File::put($spritePath, $newContent);
        return redirect()->route('admin.svgEditor');
    }
}
