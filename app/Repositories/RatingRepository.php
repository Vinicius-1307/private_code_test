<?php

namespace App\Repositories;

use App\Models\Rating;
use App\Repositories\Interfaces\RatingRepositoryInterface;

class RatingRepository implements RatingRepositoryInterface
{
    public function __construct(
        protected Rating $model
    ) {}

    /**
     * Cria ou atualiza uma avaliação
     * Usa updateOrCreate para garantir uma avaliação por usuário/receita
     * 
     * @param array $data
     * @return Rating
     */
    public function createOrUpdate(array $data): Rating
    {
        return $this->model->updateOrCreate(
            [
                'user_id' => data_get($data, 'user_id'),
                'recipe_id' => data_get($data, 'recipe_id'),
            ],
            [
                'score' => data_get($data, 'score'),
            ]
        );
    }

    /**
     * Busca avaliação de um usuário para uma receita
     * 
     * @param int $userId
     * @param int $recipeId
     * @return Rating|null
     */
    public function findByUserAndRecipe(int $userId, int $recipeId): ?Rating
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->first();
    }

    /**
     * Verifica se usuário já avaliou a receita
     * 
     * @param int $userId
     * @param int $recipeId
     * @return bool
     */
    public function userHasRated(int $userId, int $recipeId): bool
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->exists();
    }
}
