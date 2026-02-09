<?php

namespace App\Services;

use App\Models\Rating;
use App\Repositories\Interfaces\RatingRepositoryInterface;

class RatingService
{
    public function __construct(
        protected RatingRepositoryInterface $ratingRepository,
        protected RecipeService $recipeService
    ) {}

    /**
     * Cria ou atualiza uma avaliação
     * Regra de negócio: cada usuário pode avaliar apenas uma vez cada receita
     * 
     * @param int $recipeId
     * @param int $userId
     * @param int $score
     * @return Rating
     * @throws \InvalidArgumentException
     */
    public function rateRecipe(int $recipeId, int $userId, int $score): Rating
    {
        if (!$this->recipeService->recipeExists($recipeId)) {
            throw new \InvalidArgumentException("Receita com ID {$recipeId} não encontrada.");
        }

        $data = [
            'recipe_id' => $recipeId,
            'user_id' => $userId,
            'score' => $score,
        ];

        return $this->ratingRepository->createOrUpdate($data);
    }

    /**
     * Verifica se o usuário já avaliou a receita
     * 
     * @param int $userId
     * @param int $recipeId
     * @return bool
     */
    public function hasUserRated(int $userId, int $recipeId): bool
    {
        return $this->ratingRepository->userHasRated($userId, $recipeId);
    }

    /**
     * Busca a avaliação do usuário para uma receita
     * 
     * @param int $userId
     * @param int $recipeId
     * @return Rating|null
     */
    public function getUserRating(int $userId, int $recipeId): ?Rating
    {
        return $this->ratingRepository->findByUserAndRecipe($userId, $recipeId);
    }
}
