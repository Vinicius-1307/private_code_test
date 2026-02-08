<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRatingRequest;
use App\Models\Recipe;
use App\Services\RatingService;
use Illuminate\Http\RedirectResponse;

class RatingController extends Controller
{
    public function __construct(
        protected RatingService $ratingService
    ) {}

    /**
     * Cria ou atualiza uma avaliação para uma receita específica.
     * 
     * @param StoreRatingRequest $request
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function store(StoreRatingRequest $request, Recipe $recipe): RedirectResponse
    {
        $this->ratingService->rateRecipe(
            $recipe->id,
            $request->user()->id,
            $request->validated('score')
        );

        return redirect()
            ->route('recipes.show', $recipe)
            ->with('success', 'Avaliação registrada com sucesso!');
    }
}
