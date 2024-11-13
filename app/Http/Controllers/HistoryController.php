<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\HotelSocial;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = History::query();

        if ($request->has('pattern') && $request->input('pattern') != '') {
            $query->where('pattern', 'like', $request->input('pattern'));
        }
        if ($request->has('s') && $request->has('d')) {
            $sort = $request->input('s');
            $direction = $request->input('d') == 'asc' ? 'asc' : 'desc';
            $query->orderBy($sort, $direction);
        }
        $histories = $query->paginate(15)->withQueryString();
        return view('admin.histories.index', compact('histories'));
    }

    public function create()
    {
        return view('admin.histories.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'pattern' => 'required|max:255',
            'content' => 'required|max:9999',
            'order' => 'integer|min:0',
        ]);
        $history = new History();
        $history->pattern = $request->pattern;
        $history->content = json_encode($request->content);
        $history->order = $request->order;
        $history->save();
        MyLogingController::addLog('Добовалена история '.$history->id, json_encode($history));

        return redirect()->route('admin.histories.index');
    }

    public function edit(History $history)
    {
        $history->content = json_decode($history->content);
        return view('admin.histories.edit', compact('history'));
    }

    public function update(Request $request, History $history)
    {
        $this->validate($request, [
            'pattern' => 'required|max:255',
            'content' => 'required|max:9999',
            'order' => 'integer|min:0',
        ]);
        $history->pattern = $request->pattern;
        $history->content = json_encode($request->content);
        $history->order = $request->order;
        MyLogingController::addLog('Отредактирована история '.$history->id, json_encode($history->getDirty()));
        $history->save();

        return redirect()->route('admin.histories.index');
    }

    public function destroy(History $history)
    {
        MyLogingController::addLog('Удаление истории', json_encode($history));
        $history->delete();
        return redirect()->route('admin.histories.index');
    }

    public static function pageStory(){
        $histories = History::all();

        $path = request()->path();
        if ($path !== '/' && $path[0] !== '/') {
            $path = '/' . $path;
        }
        // dd($histories[0]->pattern, $path);
        foreach ($histories as $history) {
            $regex = str_replace('*', '.*', $history->pattern);

            if (preg_match("#^{$regex}$#", $path)) {
                $h = $history;
                $h->content = json_decode(json_decode($history->content));
                return $h;
            }
        }

        return false;
    }
}
