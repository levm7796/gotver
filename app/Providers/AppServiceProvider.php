<?php

namespace App\Providers;

use App\Http\Controllers\HistoryController;
use App\Models\Location;
use App\Models\Comment;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        view()->composer(['admin.layout', 'admin.home'], function($view) {
            $view->with('undreadComments',
                Comment::where('cheked', 0)->count()
            );
        });
        view()->composer(['layout', 'home'], function($view) {
            $view->with('locations',
                Location::all()
            );
            $settings = json_decode(optional(Setting::where('key', 'common')->first())->content, true);

            if(!empty($settings['roads'])){
                $settings['roads'] = json_decode($settings['roads']);
            }
            if(!empty($settings['users'])){
                $settings['users'] = json_decode($settings['users']);
            }
            if(!empty($settings['footer_links'])){
                $settings['footer_links'] = json_decode($settings['footer_links']);
            }
            $view->with('common',
                $settings
            );
            $view->with('page_story',
                HistoryController::pageStory()
            );
        });

        URL::forceScheme('https');
    }
}
