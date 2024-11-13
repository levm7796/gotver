<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $feedbacks = Feedback::query();
        if ($request->has('name') && $request->input('name') != '') {
            $feedbacks->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('email') && $request->input('email') != '') {
            $feedbacks->where('email', 'like', '%' . $request->input('email') . '%');
        }
        if ($request->has('message') && $request->input('message') != '') {
            $feedbacks->where('message', 'like', '%' . $request->input('message') . '%');
        }

        if ($request->has('s') && $request->has('d')) {
            $sort = $request->input('s');
            $direction = $request->input('d') == 'asc' ? 'asc' : 'desc';
            $feedbacks->orderBy($sort, $direction);
        }

        $feedbacks = $feedbacks->paginate(15)->withQueryString();
        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    public function destroy(Feedback $feedback)
    {
        MyLogingController::addLog('Удаление фитбэка', json_encode($feedback));
        $feedback->delete();
        return redirect()->route('admin.feedbacks.index');
    }

    public function addNew(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'message' => 'required|max:500',
        ]);
        $feedback = new Feedback();
        $feedback->name = $request->input('name');
        $feedback->email = $request->input('email');
        $feedback->message = $request->input('message');
        $feedback->save();

        MyService::mailMessageAdmin('Новый запрос обратнйо связи', route('admin.feedbacks.index'));

        return response()->json([ 'status' => 200 ], 200);
    }
}
