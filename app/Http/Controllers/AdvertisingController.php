<?php

namespace App\Http\Controllers;

use App\Models\advertising;
use App\Models\Hotel;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;

class AdvertisingController extends Controller
{
    public function index(Request $request)
    {
        $query = advertising::query();

        if ($request->has('name') && $request->input('name') != '') {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('user') && $request->input('user') != '') {
            $users = User::where('name', 'like', '%'. $request->input('user') . '%' )->pluck('id')->toArray();
            $query->whereIn('user_id', $users);
        }
        if ($request->has('phone') && $request->input('phone') != '') {
            $users = User::where('phone', 'like', '%'. $request->input('phone') . '%' )->pluck('id')->toArray();
            $query->whereIn('user_id', $users);
        }
        if ($request->has('activenow') && $request->input('activenow') != '') {
            $hotels = Hotel::query();
            $hotels->where('created_at', '<=', $request->input('activenow'));
            $hotels->where('end_date', '>=', $request->input('activenow'))->orWhereNull('end_date');
            $hotelsIds = $hotels->pluck('id')->toArray();
            $query->whereIn('hotel_id', $hotelsIds);
        }
        if ($request->has('s') && $request->has('d')) {
            $sort = $request->input('s');
            $direction = $request->input('d') == 'asc' ? 'asc' : 'desc';
            $query->orderBy($sort, $direction);
        }
        $advertisings = $query->paginate(15)->withQueryString();
        $users = User::all();
        return view('admin.advertisings.index', compact('advertisings', 'users'));
    }

    public function create()
    {
        $users = User::all();
        $hotels = Hotel::all();
        $news = News::where('type', '0')->get();
        $articles = News::where('type', '1')->get();
        return view('admin.advertisings.add', compact('users', 'hotels', 'news', 'articles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'max:255',
            'user_id' => 'required|',
            'hotel_id' => 'required|',
            'end_date' => 'required|',
            'news' => 'required|max:255',
            'articles' => 'required|max:255',
        ]);
        $advertising = new advertising();
        $advertising->name = $request->name;
        $advertising->user_id = $request->user_id;
        $advertising->hotel_id = $request->hotel_id;
        // $advertising->end_date = $request->end_date;
        $advertising->news = implode(',', $request->news);
        $advertising->articles = implode(',', $request->articles);
        $advertising->save();
        MyLogingController::addLog('Добовалена пользовательская реклама '.$advertising->id, json_encode($advertising));

        return redirect()->route('admin.advertisings.index');
    }

    public function edit(advertising $advertising)
    {
        $users = User::all();
        $hotels = Hotel::all();
        $news = News::where('type', '0')->get();
        $articles = News::where('type', '1')->get();
        return view('admin.advertisings.edit', compact('advertising', 'users', 'hotels', 'news', 'articles'));
    }

    public function update(Request $request, advertising $advertising)
    {
        $this->validate($request, [
            'name' => 'max:255',
            'user_id' => 'required|',
            'hotel_id' => 'required|',
            'end_date' => 'required|',
            'news' => 'required|max:255',
            'articles' => 'required|max:255',
        ]);
        $advertising->name = $request->name;
        $advertising->user_id = $request->user_id;
        $advertising->hotel_id = $request->hotel_id;
        $advertising->news = implode(',', $request->news);
        // $advertising->end_date = $request->end_date;
        // $advertising->created_at = $request->created_at;
        $advertising->articles = implode(',', $request->articles);
        MyLogingController::addLog('редактирование пользовательской рекламы '.$advertising->id, json_encode($advertising->getDirty()));
        $advertising->save();

        return redirect()->route('admin.advertisings.index');
    }

    public function destroy(advertising $advertising)
    {
        MyLogingController::addLog('Удаление пользовательской рекламы '.$advertising->id, json_encode($advertising));
        $advertising->delete();
        return redirect()->route('admin.advertisings.index');
    }
}
