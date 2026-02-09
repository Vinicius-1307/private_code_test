<?php

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Services\CommentService;
use App\Services\RecipeService;
use Illuminate\Database\Eloquent\Collection;

beforeEach(function () {
    $this->commentRepository = Mockery::mock(CommentRepositoryInterface::class);
    $this->recipeService = Mockery::mock(RecipeService::class);
    $this->service = new CommentService($this->commentRepository, $this->recipeService);
});

describe('createComment', function () {
    test('cria comentário com sucesso quando receita existe', function () {
        $comment = Mockery::mock(Comment::class);
        
        $this->recipeService
            ->shouldReceive('recipeExists')
            ->once()
            ->with(1)
            ->andReturn(true);
        
        $this->commentRepository
            ->shouldReceive('create')
            ->once()
            ->with([
                'recipe_id' => 1,
                'user_id' => 2,
                'body' => 'Ótima receita!',
            ])
            ->andReturn($comment);
        
        $result = $this->service->createComment(1, 2, 'Ótima receita!');
        
        expect($result)->toBe($comment);
    });

    test('lança exceção quando receita não existe', function () {
        $this->recipeService
            ->shouldReceive('recipeExists')
            ->once()
            ->with(999)
            ->andReturn(false);
        
        $this->commentRepository
            ->shouldNotReceive('create');
        
        $this->service->createComment(999, 2, 'Comentário');
    })->throws(InvalidArgumentException::class, 'Receita com ID 999 não encontrada.');

    test('valida que body não seja vazio', function () {
        $this->recipeService
            ->shouldReceive('recipeExists')
            ->once()
            ->with(1)
            ->andReturn(true);
        
        $comment = Mockery::mock(Comment::class);
        
        $this->commentRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn($comment);
        
        $result = $this->service->createComment(1, 2, 'Texto válido');
        
        expect($result)->toBe($comment);
    });
});

describe('getRecipeComments', function () {
    test('retorna comentários de uma receita', function () {
        $comments = new Collection([
            Mockery::mock(Comment::class),
            Mockery::mock(Comment::class),
            Mockery::mock(Comment::class),
        ]);
        
        $this->commentRepository
            ->shouldReceive('getByRecipe')
            ->once()
            ->with(1)
            ->andReturn($comments);
        
        $result = $this->service->getRecipeComments(1);
        
        expect($result)->toBe($comments)
            ->and($result->count())->toBe(3);
    });

    test('retorna collection vazia quando receita não tem comentários', function () {
        $comments = new Collection([]);
        
        $this->commentRepository
            ->shouldReceive('getByRecipe')
            ->once()
            ->with(1)
            ->andReturn($comments);
        
        $result = $this->service->getRecipeComments(1);
        
        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->isEmpty())->toBeTrue();
    });
});

describe('deleteComment', function () {
    test('deleta comentário com sucesso', function () {
        $comment = Mockery::mock(Comment::class);
        
        $this->commentRepository
            ->shouldReceive('delete')
            ->once()
            ->with($comment)
            ->andReturn(true);
        
        $result = $this->service->deleteComment($comment);
        
        expect($result)->toBeTrue();
    });

    test('retorna false quando exclusão falha', function () {
        $comment = Mockery::mock(Comment::class);
        
        $this->commentRepository
            ->shouldReceive('delete')
            ->once()
            ->with($comment)
            ->andReturn(false);
        
        $result = $this->service->deleteComment($comment);
        
        expect($result)->toBeFalse();
    });
});
