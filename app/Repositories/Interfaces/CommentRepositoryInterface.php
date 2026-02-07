<?php

namespace App\Repositories\Interfaces;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    /**
     * Cria um novo comentário
     * 
     * @param array $data
     * @return Comment
     */
    public function create(array $data): Comment;

    /**
     * Busca comentários de uma receita
     * 
     * @param int $recipeId
     * @return Collection
     */
    public function getByRecipe(int $recipeId): Collection;

    /**
     * Deleta um comentário
     * 
     * @param Comment $comment
     * @return bool
     */
    public function delete(Comment $comment): bool;
}
