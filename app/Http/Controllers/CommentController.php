<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $menu = Menu::find($request->id);

        if (!$menu) {
            return response()->json(['status' => 'failed']);
        }

        $comment = Comment::where('user_id', Auth::user()->uuid)->where('menu_id', $request->id)->first();

        if ($comment) {
            $comment['rating'] = $request->rating;
            if ($request->message != '')
                $comment['message'] = $request->message;
            else
                $comment['message'] = '';
        } else {
            $comment = new Comment([
                'user_id' => Auth::user()->uuid,
                'menu_id' => $menu->id,
                'rating' => (int)$request->rating,
                'message' => $request->message,
            ]);
        }
        $comment->save();

        $comments = Comment::where('menu_id', $request->id)->get();
        if (count($comments) != 0) {
            $comment_count = count($comments);
            $total_rating = 0;
            foreach ($comments as $comment) {
                $total_rating += $comment->rating;
            }
            $total_rating /= $comment_count;
            $menu->rating = $total_rating;
            $menu->save();
        }

        return response()->json(['status' => 'success', 'menu_id' => $request->id]);
    }

    /**
     * Display the specified resource.
     */
    public function get($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['status' => 'failed']);
        }

        return response()->json(['status' => 'success', 'comment' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return back()->with('error', 'Operation failed!');
        }

        $comment->forceDelete();

        return back()->with('success', 'Berhasil menghapus komen');
    }
}
