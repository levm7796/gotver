<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MyLogingController;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        $credentials['phone'] = preg_replace('/[^0-9]/', '', $credentials['phone']);
        if (Auth::attempt($credentials)) {
            MyLogingController::addLog('Пользователь авторезировался');
            return response()->json(['status' => 'ok']);
        } else {
            MyLogingController::addLog('Неудачная попытка авторизации', 'Телефон '.$request->phone);
        }
        return response()->json(['error' => 'Wrong login data']);
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('phone', 'password');
        $credentials['phone'] = preg_replace('/[^0-9]/', '', $credentials['phone']);

        if (Auth::attempt($credentials)) {
            MyLogingController::addLog('Админ авторизовался');
            // return redirect()->route('admin.home');
            return redirect()->intended();
        }else{
            MyLogingController::addLog('Неудачная попытка авторизации', 'Телефон '.$request->phone);
        }
        return back()->withErrors(['phone' => 'Wrong login data']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->back()->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '-1'
        ]);
    }
}
