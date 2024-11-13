<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\Common;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use Illuminate\Support\Carbon;
use App\Models\smscode;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{


    public function index(Request $request)
    {
        $users = User::query();
        if ($request->has('name') && $request->input('name') != '') {
            $users->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('email') && $request->input('email') != '') {
            $users->where('email', 'like', '%' . $request->input('email') . '%');
        }

        if ($request->has('phone') && $request->input('phone') != '') {
            $users->where('phone', 'like', '%' . $request->input('phone') . '%');
        }

        if ($request->has('role') && $request->input('role') != '') {
            $users->where('role_id', $request->input('role'));
        }

        if ($request->has('s') && $request->has('d')) {
            $sort = $request->input('s');
            $direction = $request->input('d') == 'asc' ? 'asc' : 'desc';
            $users->orderBy($sort, $direction);
        }

        $users = $users->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.add');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|min:2|max:256',
            'role_id'=>'required',
            'email'=>'required|min:2|max:256|unique:users,email',
            'password'=>'required|min:2|max:256',
            'phone'=>'required|min:9|max:20',
            'avatar'=>'nullable|image',
            'permission_email'=>'required|in:0,1',
            'permission_sms'=>'required|in:0,1',
        ]);

        $user = new User();
        $user->name = $request->name;
        $phone = ltrim($request->phone, '+');
        $phone = preg_replace('/\D/', '', $phone);
        $user->phone = $phone;
        $user->role_id = $request->role_id;
        $user->email = $request->email;
        $user->permission_email = $request->permission_email;
        $user->permission_sms = $request->permission_sms;
        // $user->email_verified_at = $request->email_verified_at;
        // $user->phone_verified_at = $request->phone_verified_at;
        if ($request->has('email_verified_at') && $request->input('email_verified_at') == 'on') {
            if (is_null( $user->email_verified_at)) {
                $user->email_verified_at = now();
            }
        } else {
            if (!is_null( $user->email_verified_at)) {
                $user->email_verified_at = null;
            }
        }
        if ($request->has('phone_verified_at') && $request->input('phone_verified_at') == 'on') {
            if (is_null( $user->phone_verified_at)) {
                $user->phone_verified_at = now();
            }
        } else {
            if (!is_null( $user->phone_verified_at)) {
                $user->phone_verified_at = null;
            }
        }
        $user->password = Hash::make($request->password);

        $user->save();

        MyLogingController::addLog('Создание пользователя', json_encode($user));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name'=>'required|min:2|max:256',
            'phone'=>'required|min:9|max:20',
            'role_id'=>'required',
            'email'=>'nullable|min:2|max:256',
            'avatar'=>'nullable|image',
            'delete_ava' => 'required|in:0,1',
            'password'=>'nullable|min:2|max:256',
            'permission_email'=>'required|in:0,1',
            'permission_sms'=>'required|in:0,1',
            'email_verified_at'=>'required|in:0,1',
            'phone_verified_at'=>'required|in:0,1',
        ]);

        $secondUser = User::where('email', $request->email)->whereNot('id', $user->id)->first();
        if($secondUser){
            $old = $request->all();
            return redirect()->back()->withErrors(['email' => 'The email has already been taken.'])->withInput($old);
        }

        if ($request->has('delete_ava') && $request->input('delete_ava') == '1') {

        } else {
            // if(){
            //     File::ensureDirectoryExists(public_path('avatars'));
            // }
        }


        $user->name = $request->name;
        $phone = ltrim($request->phone, '+');
        $phone = preg_replace('/\D/', '', $phone);
        $user->phone = $phone;
        $user->role_id = $request->role_id;
        $user->email = $request->email;
        $user->permission_email = $request->permission_email;
        $user->permission_sms = $request->permission_sms;
        if ($request->has('email_verified_at') && $request->input('email_verified_at') == '1') {
            if (is_null( $user->email_verified_at)) {
                $user->email_verified_at = now();
            }
        } else {
            if (!is_null( $user->email_verified_at)) {
                $user->email_verified_at = null;
            }
        }
        if ($request->has('phone_verified_at') && $request->input('phone_verified_at') == '1') {
            if (is_null( $user->phone_verified_at)) {
                $user->phone_verified_at = now();
            }
        } else {
            if (!is_null( $user->phone_verified_at)) {
                $user->phone_verified_at = null;
            }
        }
        if(!is_null($request->password))
            $user->password = Hash::make($request->password);
        MyLogingController::addLog('Редактирование пользователя', json_encode($user->getDirty()));
        $user->save();

        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        MyLogingController::addLog('Удаление пользователя', json_encode($user));
        $user->delete();
        return redirect()->route('admin.users.index');
    }

    public function registration(Request $request){
        try {
            $this->validate($request, [
                'name' => 'required|min:3|max:20',
                'phone' => 'required|min:8|max:20',
                'password' => 'required|min:2|max:32',
                'password2' => 'required|same:password',
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return ['code'=> 420 , 'errors' => $errors];
        }
        $phone = ltrim($request->phone, '+');
        $phone = preg_replace('/\D/', '', $phone);
        $user = User::where('phone', $phone)->first();
        if($user && !is_null($user->phone_verified_at))
            return response()->json(['code'=> 420 , 'errors' => ['phone'=>'exist']]);
        if(!$user){
            $user = new User();
            $user->phone = $phone;
            $user->role_id = 3;
        }
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        //TODO
        $user->phone_verified_at = Carbon::now();
        $user->save();
        MyLogingController::addLog('Регистрация пользователя', json_encode($user));

        $randomNumber = mt_rand(0, 9999);
        $formattedNumber = sprintf('%04d', $randomNumber);

        $smsCode = smscode::where('user_id', $user->id)->first();
        if(!$smsCode){
            $smsCode = new smscode();
            $smsCode->user_id = $user->id;
        }
        $smsCode->code = $formattedNumber;
        $smsCode->save();
        //Отправка смс
        MyLogingController::addLog('Отправка смс', json_encode($smsCode));
        //TODO
        Auth::login($user);
        return response()->json(["code" => 202, 'data' => 'ok']);
        return response()->json(["code" => 200, 'data' => 'ok']);
    }

    public function sendCode(Request $request){
        try {
            $this->validate($request, [
                'code' => 'required|min:4|max:4',
                'phone' => 'required|min:8|max:20',
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['code'=> 420 , 'errors' => $errors]);
        }
        $phone = ltrim($request->phone, '+');
        $phone = preg_replace('/\D/', '', $phone);

        $user = User::where('phone', $phone)->first();
        if(!$user){
            return response()->json(['code'=> 420 , 'errors' => ['phone'=>'exist']]);
        }
        if(!is_null($user) && !is_null($user->phone_verified_at))
            return response()->json(['code'=> 420 , 'errors' => ['phone'=>'verified']]);
        $smsCode = smscode::where('user_id', $user->id)->first();
        if(!$smsCode)
            return response()->json(['code'=> 420 , 'errors' => ['code'=>'exist']]);
        $code = $smsCode->code;

        if($request->code != $code){
            return ['code'=> 420 , 'errors' => ['code'=>'exist']];
        }
        $smsCode->delete();

        $user->phone_verified_at = Carbon::now();
        MyLogingController::addLog('Номер поддтвержден', json_encode($user->getDirty()));
        $user->save();
        Auth::login($user);
        return response()->json(["code" => 200, 'data' => 'ok']);
    }

    public function export(){
        $filename = 'users.csv';

        $response = response()->stream(function () {
            $handle = fopen('php://output', 'w');

            if ($handle === false) {
                // Если поток не удалось открыть, возвращаем ошибку
                abort(500, 'Cannot open output stream.');
            }

            // Запись заголовков
            fputcsv($handle, ['ID', 'Avatar', 'Name', 'Email', 'Phone','Permission email', 'Permission SMS', 'Created At', 'Updated At']);

            // Запись данных пользователей
            $users = User::all();
            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->avatar,
                    $user->name,
                    $user->email,
                    $user->phone,
                    $user->permission_email,
                    $user->permission_sms,
                    $user->created_at->format('Y-m-d H:i:s'),
                    $user->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);

        return $response;
    }

    public function profile(){
        if (!auth()->check()) {
            return abort(404);
        }

        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    public function updateAccount(Request $request){
        try {
            $this->validate($request, [
                'file' => 'nullable|image|max:5242880',
                'fileText' => 'required|min:0|max:255',
                'name' => 'required|min:3|max:20',
                'phone' => 'required|min:8|max:20',
                'email' => 'required|min:5|max:20',
                'oldPassword' => 'required|max:32',
                'newPassword' => 'nullable|min:8|max:32',
                'repeatPassword' => 'nullable|same:newPassword',
                'emailDelivery' => 'required',
                'smsDelivery' => 'required',
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['code'=> 420 , 'errors' => $errors]);
        }
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $oldPassword = $request->input('oldPassword');
        if (!Hash::check($oldPassword, $user->password)) {
            return response()->json(['code'=> 420 , 'errors' => ['oldPassword' => 'wrong']]);
        }

        switch($request->fileText){
            case "new":
                if($user->avatar)
                    Storage::delete($user->avatar);
                $fileName = time().'_'.$request->file->getClientOriginalName();
                Storage::putFileAs('/img/avatars/', $request->file, $fileName);
                $user->avatar = '/img/avatars/' . $fileName;
                break;
            case "delete":
                if($user->avatar)
                    Storage::delete($user->avatar);
                $user->avatar = null;
                break;
        }

        $emailDelivery = filter_var($request->input('emailDelivery'), FILTER_VALIDATE_BOOLEAN);
        $smsDelivery = filter_var($request->input('smsDelivery'), FILTER_VALIDATE_BOOLEAN);

        $user->name = $request->name;
        $phone = ltrim($request->phone, '+');
        $phone = preg_replace('/\D/', '', $phone);
        $user->phone = $phone;
        $user->email = $request->email;
        if($request->newPassword){
            $user->password = Hash::make($request->newPassword);
        }
        $user->permission_email = $emailDelivery ? 1 : 0;
        $user->permission_sms = $smsDelivery ? 1 : 0;
        MyLogingController::addLog('Пользователь обновил профиль', json_encode($user->getDirty()));
        $user->save();
        return response()->json(["code" => 200, 'data' => 'ok']);
    }
}
