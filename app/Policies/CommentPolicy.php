<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    public function modify(User $user, Comment $comment): Response
    {
        return $user->id === $comment->user_id ? Response::allow() : Response::deny("You do not own this post");
    }


    public function delete(User $user, Comment $comment, Post $post): Response
    {
        return $user->id === $comment->user_id
            ? Response::allow()
            : Response::deny("You do not own this comment.");
    }
}
