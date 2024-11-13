<?php

namespace App\Http\Controllers;

use App\Models\MyLoging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyLogingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = MyLoging::query();
        $logs = $logs->paginate(15)->withQueryString();
        return view('admin.logs.index', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MyLoging  $myLoging
     * @return \Illuminate\Http\Response
     */
    public function show(MyLoging $myLoging)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MyLoging  $myLoging
     * @return \Illuminate\Http\Response
     */
    public function edit(MyLoging $myLoging)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MyLoging  $myLoging
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyLoging $myLoging)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MyLoging  $myLoging
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyLoging $mylog)
    {
        $mylog->delete();
        return redirect()->route('admin.loging.index');
    }

    public static function addLog($message, $data = ""){
        $user = Auth::user();
        $ml = new MyLoging();
        if($user){
            $ml->phone = $user->phone;
            $ml->name = $user->name;
        } else {
            $ml->phone = "";
        }
        $ml->message = $message;
        $ml->data = $data;
        $ml->ip = request()->ip();
        $ml->save();

        return redirect()->route('admin.loging.index');
    }
}
