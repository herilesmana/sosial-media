<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:255',
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return response()->json($comment, 201);
    }

    public function data($postId)
    {
        $comments = Comment::where('post_id', $postId)->with('user')->latest()->get();
        return response()->json($comments);
    }
}
