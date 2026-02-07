<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function __construct(
        protected RecipeService $recipeService
    ) {}

    /**
     * Display a listing of the recipes.
     * 
     * @return View
     */
    public function index(): View
    {
        $recipes = $this->recipeService->listRecipes();

        return view('recipes.index', compact('recipes'));
    }

    /**
     * Mostra o formulário para criar uma nova receita.
     * 
     * @return View
     */
    public function create(): View
    {
        return view('recipes.create');
    }

    /**
     * Armazena uma nova receita.
     * 
     * @param StoreRecipeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRecipeRequest $request): RedirectResponse
    {
        $recipe = $this->recipeService->createRecipe(
            $request->validated(),
            $request->user()->id
        );

        return redirect()
            ->route('recipes.show', $recipe)
            ->with('success', 'Receita criada com sucesso!');
    }

    /**
     * Mostra uma receita específica.
     * 
     * @param Recipe $recipe
     * @return View
     */
    public function show(Recipe $recipe): View
    {
        $recipe = $this->recipeService->getRecipe($recipe->id);

        $userRating = null;
        if (Auth::check()) {
            $userRating = $recipe->ratings()
                ->where('user_id', Auth::id())
                ->first();
        }

        return view('recipes.show', compact('recipe', 'userRating'));
    }

    /**
     * Mostra o formulário para editar a receita especificada.
     * 
     * @param Recipe $recipe
     * @return View
     */
    public function edit(Recipe $recipe): View
    {
        $this->authorize('update', $recipe);

        return view('recipes.edit', compact('recipe'));
    }

    /**
     * Atualiza a receita especificada.
     * 
     * @param UpdateRecipeRequest $request
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe): RedirectResponse
    {
        $this->recipeService->updateRecipe($recipe, $request->validated());

        return redirect()
            ->route('recipes.show', $recipe)
            ->with('success', 'Receita atualizada com sucesso!');
    }

    /**
     * Remove a receita especificada.
     * 
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function destroy(Recipe $recipe): RedirectResponse
    {
        $this->authorize('delete', $recipe);

        $this->recipeService->deleteRecipe($recipe);

        return redirect()
            ->route('recipes.index')
            ->with('success', 'Receita deletada com sucesso!');
    }
}
