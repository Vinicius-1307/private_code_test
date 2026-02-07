<?php

namespace App\Repositories\Interfaces;

use App\Models\Recipe;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface RecipeRepositoryInterface
{
    /**
     * Lista todas as receitas com eager loading e agregações
     * 
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllWithRelations(int $perPage = 15): LengthAwarePaginator;

    /**
     * Busca uma receita específica com relacionamentos
     * 
     * @param int $id
     * @return Recipe|null
     */
    public function findWithRelations(int $id): ?Recipe;

    /**
     * Cria uma nova receita
     * 
     * @param array $data
     * @return Recipe
     */
    public function create(array $data): Recipe;

    /**
     * Atualiza uma receita
     * 
     * @param Recipe $recipe
     * @param array $data
     * @return bool
     */
    public function update(Recipe $recipe, array $data): bool;

    /**
     * Deleta uma receita
     * 
     * @param Recipe $recipe
     * @return bool
     */
    public function delete(Recipe $recipe): bool;

    /**
     * Busca receitas de um usuário específico
     * 
     * @param int $userId
     * @return Collection
     */
    public function getByUser(int $userId): Collection;
}
