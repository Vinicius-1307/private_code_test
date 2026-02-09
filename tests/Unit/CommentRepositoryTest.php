<?php

use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\Collection;

beforeEach(function () {
    $this->model = Mockery::mock(Comment::class);
    $this->repository = new CommentRepository($this->model);
});

describe('create', function () {
    test('cria novo comentário', function () {
        $data = [
            'recipe_id' => 1,
            'user_id' => 2,
            'body' => 'Ótima receita!',
        ];
        
        $comment = Mockery::mock(Comment::class);
        
        $this->model
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($comment);
        
        $result = $this->repository->create($data);
        
        expect($result)->toBe($comment);
    });
});

describe('getByRecipe', function () {
    test('retorna comentários de uma receita com eager loading', function () {
        $comments = new Collection();
        
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('recipe_id', 1)
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('with')
            ->once()
            ->with('user:id,name')
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('orderBy')
            ->once()
            ->with('created_at', 'desc')
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('get')
            ->once()
            ->andReturn($comments);
        
        $result = $this->repository->getByRecipe(1);
        
        expect($result)->toBe($comments);
    });

    test('retorna em ordem decrescente de criação', function () {
        $comments = new Collection();
        
        $this->model
            ->shouldReceive('where')
            ->once()
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('with')
            ->once()
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('orderBy')
            ->once()
            ->with('created_at', 'desc')
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('get')
            ->once()
            ->andReturn($comments);
        
        $result = $this->repository->getByRecipe(1);
        
        expect($result)->toBe($comments);
    });
});

describe('delete', function () {
    test('deleta comentário com sucesso', function () {
        $comment = Mockery::mock(Comment::class);
        
        $comment
            ->shouldReceive('delete')
            ->once()
            ->andReturn(true);
        
        $result = $this->repository->delete($comment);
        
        expect($result)->toBeTrue();
    });

    test('retorna false quando exclusão falha', function () {
        $comment = Mockery::mock(Comment::class);
        
        $comment
            ->shouldReceive('delete')
            ->once()
            ->andReturn(false);
        
        $result = $this->repository->delete($comment);
        
        expect($result)->toBeFalse();
    });
});
