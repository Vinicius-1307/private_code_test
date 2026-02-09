<?php

namespace App\Services;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CommentService
{
    public function __construct(
        protected CommentRepositoryInterface $commentRepository,
        protected RecipeService $recipeService
    ) {}

    /**
     * Cria um novo comentário em uma receita
     * 
     * @param int $recipeId
     * @param int $userId
     * @param string $body
     * @return Comment
     * @throws \InvalidArgumentException
     */
    public function createComment(int $recipeId, int $userId, string $body): Comment
    {
        if (!$this->recipeService->recipeExists($recipeId)) {
            throw new \InvalidArgumentException("Receita com ID {$recipeId} não encontrada.");
        }

        $data = [
            'recipe_id' => $recipeId,
            'user_id' => $userId,
            'body' => $body,
        ];

        return $this->commentRepository->create($data);
    }

    /**
     * Lista comentários de uma receita
     * 
     * @param int $recipeId
     * @return Collection
     */
    public function getRecipeComments(int $recipeId): Collection
    {
        return $this->commentRepository->getByRecipe($recipeId);
    }

    /**
     * Deleta um comentário
     * 
     * @param Comment $comment
     * @return bool
     */
    public function deleteComment(Comment $comment): bool
    {
        return $this->commentRepository->delete($comment);
    }
}
