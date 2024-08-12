<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|max:2048', // Adjust the max size as needed
        ]);

        $post = new Post();
        $post->user_id = auth()->id();
        $post->content = $request->content;

        if ($request->hasFile('attachment')) {
            $post->attachment = $request->file('attachment')->store('attachments', 'public');
        }

        $post->save();

        return response()->json($post, 201);
    }

    public function data()
    {
        $posts = Post::with('user')->latest()->get();

        return response()->json($posts);
    }
}
