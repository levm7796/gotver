<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OptionController extends Controller
{
    public function index(Request $request)
    {
        $options = Option::query();

        if ($request->has('s') && $request->has('d')) {
            $sort = $request->input('s');
            $direction = $request->input('d') == 'asc' ? 'asc' : 'desc';
            $options->orderBy($sort, $direction);
        }

        $options = $options->paginate(15)->withQueryString();
        return view('admin.options.index', compact('options'));
    }
    public function create()
    {
        $svgs = $this->getSvg();
        return view('admin.options.add', compact('svgs'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:255',
            'ico' => 'required|max:255',
        ]);
        $option = new Option();
        $option->ico = $request->ico;
        $option->name = $request->ico;
        $option->content = $request->content;
        $option->save();
        MyLogingController::addLog('Добавлена опция отэля', json_encode($option));

        return redirect()->route('admin.options.index');
    }

    public function edit(Option $option)
    {
        $svgs = $this->getSvg();
        return view('admin.options.edit', compact('option', 'svgs'));
    }

    public function update(Request $request, Option $option)
    {
        $this->validate($request, [
            'content' => 'required|max:255',
            'ico' => 'required|max:255',
        ]);
        $option = new Option();
        $option->ico = $request->ico;
        $option->name = $request->ico;
        $option->content = $request->content;
        MyLogingController::addLog('Отредактирована опция отэля', json_encode($option->getDirty()));
        $option->save();

        return redirect()->route('admin.options.index');
    }

    public function destroy(Request $request, Option $option){
        MyLogingController::addLog('Удалена опция отэля', json_encode($option));
        $option->delete();
        return redirect()->route('admin.options.index');
    }

    function getSvg(){
        $spritePath = public_path('/img/sprite.svg');
        $spriteContent = File::get($spritePath);
        preg_match_all('/<symbol\s+id="([^"]+)"/', $spriteContent, $matches);
        $symbolIds = $matches[1];
        return $symbolIds;
    }
}
