<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;

use App\Models\Redirect;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function index(Request $request)
    {
        $redirects = Redirect::query();
        if ($request->has('from') && $request->input('from') != '') {
            $redirects->where('from', 'like', '%' . $request->input('from') . '%');
        }
        if ($request->has('to') && $request->input('to') != '') {
            $redirects->where('to', 'like', '%' . $request->input('to') . '%');
        }
        if ($request->has('active') && $request->input('active') != '') {
            $redirects->where('active', $request->input('active'));
        }
        if ($request->has('code') && $request->input('code') != '') {
            $redirects->where('code', $request->input('code'));
        }
        if ($request->has('s') && $request->has('d')) {
            $sort = $request->input('s');
            $direction = $request->input('d') == 'asc' ? 'asc' : 'desc';
            $redirects->orderBy($sort, $direction);
        }

        $redirects = $redirects->paginate(15)->withQueryString();
        return view('admin.redirects.index', compact('redirects'));
    }

    public function create()
    {
        return view('admin.redirects.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'from' => 'required|max:255',
            'to' => 'required|max:255',
            'active' => 'in:0,1',
            'code' => 'integer|min:0|max:999',
            'order' => 'integer|min:0|max:99999',
        ]);
        $redirect = new Redirect();
        $redirect->from = $request->from;
        $redirect->to = $request->to;
        $redirect->code = $request->code;
        $redirect->order = $request->order;
        MyLogingController::addLog('Добавлен редирект', json_encode($redirect));
        $redirect->save();
        Cache::forget('active_redirects');
        return redirect()->route('admin.redirects.index');
    }

    public function edit(Redirect $redirect)
    {
        return view('admin.redirects.edit', compact('redirect'));
    }

    public function update(Request $request, Redirect $redirect)
    {
        $this->validate($request, [
            'from' => 'required|max:255',
            'to' => 'required|max:255',
            'active' => 'in:0,1',
            'code' => 'integer|min:0|max:999',
            'order' => 'integer|min:0|max:99999',
        ]);
        $redirect->from = $request->from;
        $redirect->to = $request->to;
        $redirect->active = $request->active;
        $redirect->code = $request->code;
        $redirect->order = $request->order;
        MyLogingController::addLog('Отредактирован редирект', json_encode($redirect->getDirty()));
        $redirect->save();
        Cache::forget('active_redirects');
        return redirect()->route('admin.redirects.index');
    }

    public function destroy(Request $request, Redirect $redirect){
        MyLogingController::addLog('Удален редирект', json_encode($redirect));
        $redirect->delete();
        Cache::forget('active_redirects');
        return redirect()->route('admin.redirects.index');
    }
}
