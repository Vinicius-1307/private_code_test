<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    public function __construct(
        protected Comment $model
    ) {}

    /**
     * Cria um novo comentário
     * 
     * @param array $data
     * @return Comment
     */
    public function create(array $data): Comment
    {
        return $this->model->create($data);
    }

    /**
     * Busca comentários de uma receita com eager loading do usuário
     * 
     * @param int $recipeId
     * @return Collection
     */
    public function getByRecipe(int $recipeId): Collection
    {
        return $this->model
            ->where('recipe_id', $recipeId)
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Deleta um comentário
     * 
     * @param Comment $comment
     * @return bool
     */
    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }
}
