<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertisingController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelPageController;
use App\Http\Controllers\HubController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MyLogingController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsPageController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Models\MyLoging;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['redirectModule'])->group(function(){
    Route::get('/', [MainController::class, 'mainIndex'])->name('home');
    Route::post('/l/{locationId}', [MainController::class, 'mainIndexLocation'])->name('home.location');

    Route::post('/location/hotels-filter', [LocationController::class, 'locationFilter'])->name('locationFilter');
    Route::get('/location/{location}', [LocationController::class, 'locationIndex'])->name('locationIndex');
    Route::post('/hub/hotels-sort', [HubController::class, 'hubSort'])->name('hubSort');
    Route::post('/hub/artiles-sort', [HubController::class, 'hubSort2'])->name('hubSort2');
    Route::get('/hub/{hub}', [HubController::class, 'hubIndex'])->name('hubIndex');
    Route::get('/tag/{tag}', [TagController::class, 'tagIndex'])->name('tagIndex');

    Route::get('/news', [NewsController::class, 'allnews'])->name('allnews');
    Route::post('/news/news-sort', [NewsController::class, 'allNewsSort'])->name('allnews.sort');
    Route::get('/articles', [NewsController::class, 'allarticle'])->name('allarticle');

    Route::get('/news/{news}', [NewsPageController::class, 'index'])->name('news.index');
    Route::get('/object/{hotel}', [HotelPageController::class, 'index'])->name('hotel.index');
    Route::get('/article/{article}', [NewsPageController::class, 'articleIndex'])->name('allarticle.index');

    // Route::get('/news/{news}', [NewsPageController::class, 'index'])->name('allnews.index');
    Route::middleware('auth')->prefix('profile')->group(function () {
        Route::get('/', [UserController::class, 'profile'])->name('profile');
        Route::get('/favorite/update/{key?}', [UserController::class, 'favoriteUpdate'])->name('favoriteUpdate');
        Route::get('/favorite/list/{page?}', [UserController::class, 'favoriteList'])->name('favoriteList');
        Route::get('/comment/list/{page?}', [UserController::class, 'commentList'])->name('commentList');
    });
    Route::post('/update-account', [UserController::class, 'updateAccount'])->name('updateAccount')->middleware('auth');

    Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
    Route::post('/registration', [UserController::class, 'registration'])->name('registration');
    Route::post('/send-code', [UserController::class, 'sendCode'])->name('sendcode');

    Route::post('/addfeedback', [FeedbackController::class, 'addNew'])->name('addNew');
    Route::post('/addComment/{table}/{id}', [CommentController::class, 'store'])->name('addComment')->middleware('auth');
    Route::post('/comment/answerComment/{table}/{id}/{commentId}', [CommentController::class, 'answer'])->name('answerComment')->middleware('auth');
    Route::post('/comment/{id}/{like}', [CommentController::class, 'like'])->name('like')->middleware('throttle:15,1');
    //show more comments
    Route::post('/comments/{table}/{id}/{filter}/', [CommentController::class, 'showMore'])->name('showMore');
    Route::post('/news/changeLike/{like}/{id}', [CommentController::class, 'changeLike'])->name('changeLike')->middleware('auth');
    Route::post('/news/favorite/{table}/{id}', [CommentController::class, 'favorite'])->name('favorite')->middleware('auth');
    Route::post('/news/commentSort/{table}/{id}/{index}', [CommentController::class, 'commentSort'])->name('commentSort');

    Route::post('/hotel/image', [HotelController::class, 'images'])->name('images');
    Route::get('/hotel/link/{hotelId}/{redirect}', [HotelController::class, 'statisticRedirect'])->name('statisticRedirect');
    Route::get('/hotel/phone/{hotelId}', [HotelController::class, 'statisticPhone'])->name('statisticPhone');
    Route::post('/hotel/deleteImages', [HotelController::class, 'deleteImages'])->name('deleteImages');
    Route::post('/hotel/favorite/{table}/{id}', [HotelController::class, 'favorite'])->name('hotelFavorite')->middleware('auth');

    Route::post('/news/image', [NewsController::class, 'images'])->name('newsImages');
    Route::post('/news/deleteImages', [NewsController::class, 'deleteImages'])->name('newsDeleteImages');

    Route::get('/login-admin', function(){ return view('admin.login'); })->name('admin.login')->middleware('guest');
    Route::post('/login-admin', [AuthController::class, 'loginAdmin'])->name('admin.login.post')->middleware('guest');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::get('/terms-of-service', [MainController::class, 'tos'])->name('tos');
    Route::get('/terms-and-conditions', [MainController::class, 'tac'])->name('tac');

    Route::post('/search', [MainController::class, 'search'])->name('search');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return view('admin.welcome');
        })->name('home');
        //middleware('admin')->
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/export', [UserController::class, 'export'])->name('export');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/create', [UserController::class, 'store'])->name('store');
            Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
            Route::post('/edit/{user}', [UserController::class, 'update'])->name('update');
            Route::get('/delete/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('locations')->name('locations.')->group(function () {
            Route::get('/', [LocationController::class, 'index'])->name('index');
            Route::get('/create', [LocationController::class, 'create'])->name('create');
            Route::post('/create', [LocationController::class, 'store'])->name('store');
            Route::get('/edit/{location}', [LocationController::class, 'edit'])->name('edit');
            Route::post('/edit/{location}', [LocationController::class, 'update'])->name('update');
            Route::get('/delete/{location}', [LocationController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('hotels')->name('hotels.')->group(function () {
            Route::get('/', [HotelController::class, 'index'])->name('index');
            Route::get('/create', [HotelController::class, 'create'])->name('create');
            Route::post('/create', [HotelController::class, 'store'])->name('store');
            Route::get('/edit/{hotels}', [HotelController::class, 'edit'])->name('edit');
            Route::post('/edit/{hotels}', [HotelController::class, 'update'])->name('update');
            Route::get('/delete/{hotels}', [HotelController::class, 'destroy'])->name('destroy');
            Route::get('/restart/{hotels}', [HotelController::class, 'restart'])->name('restart');
        });

        Route::prefix('tags')->name('tags.')->group(function () {
            Route::get('/', [TagController::class, 'index'])->name('index');
            Route::get('/create', [TagController::class, 'create'])->name('create');
            Route::post('/create', [TagController::class, 'store'])->name('store');
            Route::get('/edit/{tag}', [TagController::class, 'edit'])->name('edit');
            Route::post('/edit/{tag}', [TagController::class, 'update'])->name('update');
            Route::get('/delete/{tag}', [TagController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('news')->name('news.')->group(function () {
            Route::get('/', [NewsController::class, 'index'])->name('index');
            Route::get('/create', [NewsController::class, 'create'])->name('create');
            Route::post('/create', [NewsController::class, 'store'])->name('store');
            Route::get('/edit/{news}', [NewsController::class, 'edit'])->name('edit');
            Route::post('/edit/{news}', [NewsController::class, 'update'])->name('update');
            Route::get('/delete/{news}', [NewsController::class, 'destroy'])->name('destroy');
            Route::get('/restart/{news}', [NewsController::class, 'restart'])->name('restart');
        });

        Route::prefix('articles')->name('articles.')->group(function () {
            Route::get('/', [ArticlesController::class, 'index'])->name('index');
            Route::get('/create', [ArticlesController::class, 'create'])->name('create');
            Route::post('/create', [ArticlesController::class, 'store'])->name('store');
            Route::get('/edit/{news}', [ArticlesController::class, 'edit'])->name('edit');
            Route::post('/edit/{news}', [ArticlesController::class, 'update'])->name('update');
            Route::get('/delete/{news}', [ArticlesController::class, 'destroy'])->name('destroy');
            Route::get('/restart/{news}', [ArticlesController::class, 'restart'])->name('restart');
        });

        Route::prefix('anonses')->name('anonses.')->group(function () {
            Route::get('/', [ArticlesController::class, 'anonsIndex'])->name('index');
            Route::get('/create', [ArticlesController::class, 'anonsCreate'])->name('create');
            Route::post('/create', [ArticlesController::class, 'anonsStore'])->name('store');
            Route::get('/edit/{news}', [ArticlesController::class, 'anonsEdit'])->name('edit');
            Route::post('/edit/{news}', [ArticlesController::class, 'anonsUpdate'])->name('update');
            Route::get('/delete/{news}', [ArticlesController::class, 'anonsDestroy'])->name('destroy');
            // Route::get('/restart/{news}', [ArticlesController::class, 'restart'])->name('restart');
        });

        Route::prefix('hubs')->name('hubs.')->group(function () {
            Route::get('/', [HubController::class, 'index'])->name('index');
            Route::get('/create', [HubController::class, 'create'])->name('create');
            Route::post('/create', [HubController::class, 'store'])->name('store');
            Route::get('/edit/{hub}', [HubController::class, 'edit'])->name('edit');
            Route::post('/edit/{hub}', [HubController::class, 'update'])->name('update');
            Route::get('/delete/{hub}', [HubController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('comments')->name('comments.')->group(function () {
            Route::get('/', [CommentController::class, 'index'])->name('index');
            // Route::get('/create', [CommentController::class, 'create'])->name('create');
            // Route::post('/create', [CommentController::class, 'store'])->name('store');
            Route::get('/edit/{comment}', [CommentController::class, 'edit'])->name('edit');
            Route::post('/edit/{comment}', [CommentController::class, 'update'])->name('update');
            Route::get('/delete/{comment}', [CommentController::class, 'destroy'])->name('destroy');
            Route::post('/web-delete/{comment}', [CommentController::class, 'destroy2'])->name('destroy2');
        });

        Route::prefix('histories')->name('histories.')->group(function () {
            Route::get('/', [HistoryController::class, 'index'])->name('index');
            Route::get('/create', [HistoryController::class, 'create'])->name('create');
            Route::post('/create', [HistoryController::class, 'store'])->name('store');
            Route::get('/edit/{history}', [HistoryController::class, 'edit'])->name('edit');
            Route::post('/edit/{history}', [HistoryController::class, 'update'])->name('update');
            Route::get('/delete/{history}', [HistoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('options')->name('options.')->group(function () {
            Route::get('/', [OptionController::class, 'index'])->name('index');
            Route::get('/create', [OptionController::class, 'create'])->name('create');
            Route::post('/create', [OptionController::class, 'store'])->name('store');
            Route::get('/edit/{option}', [OptionController::class, 'edit'])->name('edit');
            Route::post('/edit/{option}', [OptionController::class, 'update'])->name('update');
            Route::get('/delete/{option}', [OptionController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('advertisings')->name('advertisings.')->group(function () {
            Route::get('/', [AdvertisingController::class, 'index'])->name('index');
            Route::get('/create', [AdvertisingController::class, 'create'])->name('create');
            Route::post('/create', [AdvertisingController::class, 'store'])->name('store');
            Route::get('/edit/{advertising}', [AdvertisingController::class, 'edit'])->name('edit');
            Route::post('/edit/{advertising}', [AdvertisingController::class, 'update'])->name('update');
            Route::get('/delete/{advertising}', [AdvertisingController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('redirects')->name('redirects.')->group(function () {
            Route::get('/', [RedirectController::class, 'index'])->name('index');
            Route::get('/create', [RedirectController::class, 'create'])->name('create');
            Route::post('/create', [RedirectController::class, 'store'])->name('store');
            Route::get('/edit/{redirect}', [RedirectController::class, 'edit'])->name('edit');
            Route::post('/edit/{redirect}', [RedirectController::class, 'update'])->name('update');
            Route::get('/delete/{redirect}', [RedirectController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('feedbacks')->name('feedbacks.')->group(function () {
            Route::get('/', [FeedbackController::class, 'index'])->name('index');
            // Route::get('/create', [FeedbackController::class, 'create'])->name('create');
            // Route::post('/create', [FeedbackController::class, 'store'])->name('store');
            // Route::get('/edit/{feedback}', [FeedbackController::class, 'edit'])->name('edit');
            // Route::post('/edit/{feedback}', [FeedbackController::class, 'update'])->name('update');
            Route::get('/delete/{feedback}', [FeedbackController::class, 'destroy'])->name('destroy');
        });


        Route::prefix('loging')->name('loging.')->group(function () {
            Route::get('/', [MyLogingController::class, 'index'])->name('index');
            Route::get('/delete/{mylog}', [MyLogingController::class, 'destroy'])->name('destroy');
        });


        Route::post('/editor-upload', [AdminController::class, 'editorUpload'])->name('editorUpload');
        Route::post('/editor-delete', [AdminController::class, 'editorDelete'])->name('editorDelete');

        Route::get('/settings/svg-editor', [AdminController::class, 'svgEditor'])->name('svgEditor');
        Route::post('/settings/svg-editor', [AdminController::class, 'svgEditorPost'])->name('svgEditor.edit');

        Route::get('/settings/all-news', [AdminController::class, 'allNews'])->name('allNews');
        Route::post('/settings/all-news', [AdminController::class, 'allNewsPost'])->name('allNews.edit');

        Route::get('/settings/all-articles', [AdminController::class, 'allArticles'])->name('allArticles');
        Route::post('/settings/all-articles', [AdminController::class, 'allArticlesPost'])->name('allArticles.edit');

        Route::get('/settings/common', [AdminController::class, 'common'])->name('common');
        Route::post('/settings/common', [AdminController::class, 'commonPost'])->name('common.edit');

        Route::get('/settings/main', [AdminController::class, 'main'])->name('main');
        Route::post('/settings/main', [AdminController::class, 'mainPost'])->name('main.edit');

        Route::get('/settings/back', [AdminController::class, 'back'])->name('back');
        Route::post('/settings/back', [AdminController::class, 'backPost'])->name('back.edit');
        Route::get('/gen-sitemap', [AdminController::class, 'genSitemap'])->name('genSitemap');

        Route::get('/settings/{name}', [AdminController::class, 'universal'])->name('universal');
        Route::post('/settings/{name}', [AdminController::class, 'universalPost'])->name('universal.edit');

    });
});
