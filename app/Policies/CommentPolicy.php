<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine se o usuário pode deletar o comentário.
     * Permite deletar se for o autor do comentário ou o dono da receita.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || 
               $user->id === $comment->recipe->user_id;
    }
}
