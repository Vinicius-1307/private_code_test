<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
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
        try {
            $this->commentService->createComment(
                $recipe->id,
                $request->user()->id,
                $request->validated('body')
            );

            return redirect()
                ->route('recipes.show', $recipe)
                ->with('success', 'Comentário adicionado com sucesso!');
        } catch (\InvalidArgumentException $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao adicionar comentário. Por favor, tente novamente.');
        }
    }

    /**
     * Remove um comentário.
     * 
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);
        
        $recipeId = $comment->recipe_id;
        
        try {
            $this->commentService->deleteComment($comment);

            return redirect()
                ->route('recipes.show', $recipeId)
                ->with('success', 'Comentário deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao deletar comentário. Por favor, tente novamente.');
        }
    }
}
