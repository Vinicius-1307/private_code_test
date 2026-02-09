<?php

use App\Models\Rating;
use App\Repositories\RatingRepository;

beforeEach(function () {
    $this->model = Mockery::mock(Rating::class);
    $this->repository = new RatingRepository($this->model);
});

describe('createOrUpdate', function () {
    test('cria nova avaliação', function () {
        $data = [
            'recipe_id' => 1,
            'user_id' => 2,
            'score' => 5,
        ];
        
        $rating = Mockery::mock(Rating::class);
        
        $this->model
            ->shouldReceive('updateOrCreate')
            ->once()
            ->with(
                [
                    'user_id' => 2,
                    'recipe_id' => 1,
                ],
                [
                    'score' => 5,
                ]
            )
            ->andReturn($rating);
        
        $result = $this->repository->createOrUpdate($data);
        
        expect($result)->toBe($rating);
    });

    test('atualiza avaliação existente', function () {
        $data = [
            'recipe_id' => 1,
            'user_id' => 2,
            'score' => 4,
        ];
        
        $rating = Mockery::mock(Rating::class);
        
        $this->model
            ->shouldReceive('updateOrCreate')
            ->once()
            ->with(
                [
                    'user_id' => 2,
                    'recipe_id' => 1,
                ],
                [
                    'score' => 4,
                ]
            )
            ->andReturn($rating);
        
        $result = $this->repository->createOrUpdate($data);
        
        expect($result)->toBe($rating);
    });

    test('garante uma avaliação por usuário e receita', function () {
        $data = [
            'recipe_id' => 1,
            'user_id' => 2,
            'score' => 3,
        ];
        
        $rating = Mockery::mock(Rating::class);
        
        $this->model
            ->shouldReceive('updateOrCreate')
            ->once()
            ->andReturn($rating);
        
        $result = $this->repository->createOrUpdate($data);
        
        expect($result)->toBeInstanceOf(Rating::class);
    });
});

describe('findByUserAndRecipe', function () {
    test('retorna avaliação do usuário para receita', function () {
        $rating = Mockery::mock(Rating::class);
        
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('user_id', 1)
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('recipe_id', 2)
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('first')
            ->once()
            ->andReturn($rating);
        
        $result = $this->repository->findByUserAndRecipe(1, 2);
        
        expect($result)->toBe($rating);
    });

    test('retorna null quando não há avaliação', function () {
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('user_id', 1)
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('recipe_id', 2)
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('first')
            ->once()
            ->andReturn(null);
        
        $result = $this->repository->findByUserAndRecipe(1, 2);
        
        expect($result)->toBeNull();
    });
});

describe('userHasRated', function () {
    test('retorna true quando usuário já avaliou', function () {
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('user_id', 1)
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('recipe_id', 2)
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('exists')
            ->once()
            ->andReturn(true);
        
        $result = $this->repository->userHasRated(1, 2);
        
        expect($result)->toBeTrue();
    });

    test('retorna false quando usuário não avaliou', function () {
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('user_id', 1)
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('recipe_id', 2)
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('exists')
            ->once()
            ->andReturn(false);
        
        $result = $this->repository->userHasRated(1, 2);
        
        expect($result)->toBeFalse();
    });
});
