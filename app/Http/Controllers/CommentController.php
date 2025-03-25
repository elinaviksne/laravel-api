<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index($post_id)
    {
        $post = Post::with('comments')->find($post_id);
        return $post;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $request->content,
        ]);

        return $comment;
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        // if ($comment->post_id !== $post->id) {
        //     return ['message' => 'Comment does not belong to this post.'];
        // }

        Gate::authorize('modify', $comment);
        $fields = $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($fields);

        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
