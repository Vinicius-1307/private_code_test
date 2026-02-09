<?php

namespace App\Repositories;

use App\Models\Recipe;
use App\Repositories\Interfaces\RecipeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RecipeRepository implements RecipeRepositoryInterface
{
    public function __construct(
        protected Recipe $model
    ) {}

    /**
     * Lista todas as receitas com eager loading e agregações
     * Evita N+1 queries carregando user, ratings_avg e ratings_count
     * 
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllWithRelations(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with('user:id,name')
            ->withRatingsAggregate()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Busca uma receita específica com relacionamentos
     * Carrega user, comments com user, e agregações de rating
     * 
     * @param int $id
     * @return Recipe|null
     */
    public function findWithRelations(int $id): ?Recipe
    {
        return $this->model
            ->with([
                'user:id,name',
                'comments' => function ($query) {
                    $query->with('user:id,name')
                          ->orderBy('created_at', 'desc');
                }
            ])
            ->withRatingsAggregate()
            ->find($id);
    }

    /**
     * Cria uma nova receita
     * 
     * @param array $data
     * @return Recipe
     */
    public function create(array $data): Recipe
    {
        return $this->model->create($data);
    }

    /**
     * Atualiza uma receita
     * 
     * @param Recipe $recipe
     * @param array $data
     * @return bool
     */
    public function update(Recipe $recipe, array $data): bool
    {
        return $recipe->update($data);
    }

    /**
     * Deleta uma receita
     * 
     * @param Recipe $recipe
     * @return bool
     */
    public function delete(Recipe $recipe): bool
    {
        return $recipe->delete();
    }

    /**
     * Busca receitas de um usuário específico
     * 
     * @param int $userId
     * @return Collection
     */
    public function getByUser(int $userId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->withRatingsAggregate()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Verifica se uma receita existe
     * 
     * @param int $id
     * @return bool
     */
    public function exists(int $id): bool
    {
        return $this->model->where('id', $id)->exists();
    }
}
