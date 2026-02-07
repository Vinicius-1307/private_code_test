<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;

class RecipePolicy
{
    /**
     * Determina se o usuário pode editar a receita.
     * Apenas o criador pode editar.
     * 
     * @param User $user
     * @param Recipe $recipe
     * @return bool
     */
    public function update(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id;
    }

    /**
     * Determina se o usuário pode deletar a receita.
     * Apenas o criador pode deletar.
     * 
     * @param User $user
     * @param Recipe $recipe
     * @return bool
     */
    public function delete(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id;
    }
}
