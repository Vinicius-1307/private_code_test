<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Recipe;
use App\Services\CommentService;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function __construct(
        protected CommentService $commentService
    ) {}

    /**
     * Cria um novo comentário para uma receita específica.
     * 
     * @param StoreCommentRequest $request
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function store(StoreCommentRequest $request, Recipe $recipe): RedirectResponse
    {
        $this->commentService->createComment(
            $recipe->id,
            $request->user()->id,
            $request->validated('body')
        );

        return redirect()
            ->route('recipes.show', $recipe)
            ->with('success', 'Comentário adicionado com sucesso!');
    }
}
