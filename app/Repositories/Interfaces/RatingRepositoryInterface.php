<?php

namespace App\Repositories\Interfaces;

use App\Models\Rating;

interface RatingRepositoryInterface
{
    /**
     * Cria ou atualiza uma avaliação
     * 
     * @param array $data
     * @return Rating
     */
    public function createOrUpdate(array $data): Rating;

    /**
     * Busca avaliação de um usuário para uma receita
     * 
     * @param int $userId
     * @param int $recipeId
     * @return Rating|null
     */
    public function findByUserAndRecipe(int $userId, int $recipeId): ?Rating;

    /**
     * Verifica se usuário já avaliou a receita
     * 
     * @param int $userId
     * @param int $recipeId
     * @return bool
     */
    public function userHasRated(int $userId, int $recipeId): bool;
}
