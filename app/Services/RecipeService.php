<?php

namespace App\Services;

use App\Models\Recipe;
use App\Repositories\Interfaces\RecipeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RecipeService
{
    public function __construct(
        protected RecipeRepositoryInterface $recipeRepository
    ) {}

    /**
     * Lista todas as receitas com paginação
     * 
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function listRecipes(int $perPage = 15): LengthAwarePaginator
    {
        return $this->recipeRepository->getAllWithRelations($perPage);
    }

    /**
     * Busca uma receita específica
     * 
     * @param int $id
     * @return Recipe|null
     */
    public function getRecipe(int $id): ?Recipe
    {
        return $this->recipeRepository->findWithRelations($id);
    }

    /**
     * Cria uma nova receita
     * 
     * @param array $data
     * @param int $userId
     * @return Recipe
     */
    public function createRecipe(array $data, int $userId): Recipe
    {
        $data['user_id'] = $userId;
        
        return $this->recipeRepository->create($data);
    }

    /**
     * Atualiza uma receita existente
     * 
     * @param Recipe $recipe
     * @param array $data
     * @return bool
     */
    public function updateRecipe(Recipe $recipe, array $data): bool
    {
        return $this->recipeRepository->update($recipe, $data);
    }

    /**
     * Deleta uma receita
     * 
     * @param Recipe $recipe
     * @return bool
     */
    public function deleteRecipe(Recipe $recipe): bool
    {
        return $this->recipeRepository->delete($recipe);
    }

    /**
     * Busca receitas de um usuário
     * 
     * @param int $userId
     * @return Collection
     */
    public function getUserRecipes(int $userId): Collection
    {
        return $this->recipeRepository->getByUser($userId);
    }

    /**
     * Verifica se uma receita existe
     * 
     * @param int $id
     * @return bool
     */
    public function recipeExists(int $id): bool
    {
        return $this->recipeRepository->exists($id);
    }
}
