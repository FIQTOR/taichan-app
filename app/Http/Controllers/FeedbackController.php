<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages/feedback', ['title' => 'Masukan']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'fullname' => ['required'],
            'email' => ['required', 'email'],
            'message' => ['required'],
        ], [
            'email.required' => ':attribute wajib di isi',
            'password.required' => ':attribute wajib di isi',
            'message.required' => ':attribute wajib di isi',
        ]);

        $newFeedback = new Feedback([
            'user_id' => Auth::user()->uuid,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'type' => $request->type,
            'message' => $request->message,
        ]);
        if ($request->phonenumber)
            $newFeedback['phonenumber'] = $request->phonenumber;
        $newFeedback->save();

        return redirect()->to(route('feedback'))->with('success', 'Pesan berhasil dikirim');
    }

    public function dataFeedback()
    {
        $feedbacks = Feedback::all();

        return view('pages/staff/feedback-data', [
            'title' => 'Data Masukan',
            'feedbacks' => $feedbacks
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'uuid' => ['required']
        ]);

        $feedback = Feedback::find($request->uuid);
        if (!$feedback)
            return back()->with('error', 'Operasi Gagal!');

        $feedback->forceDelete();

        return back()->with('success', 'Berhasil menghapus masukan!');
    }

    public function search(Request $request)
    {
        $feedbacks = Feedback::where('type', 'like', '%' . $request->get('keyword') . '%')->orWhere('fullname', 'like', '%' . $request->get('keyword') . '%')->get();

        return response()->json($feedbacks);
    }
}
