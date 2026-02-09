<?php

use App\Models\Rating;
use App\Repositories\Interfaces\RatingRepositoryInterface;
use App\Services\RatingService;
use App\Services\RecipeService;

beforeEach(function () {
    $this->ratingRepository = Mockery::mock(RatingRepositoryInterface::class);
    $this->recipeService = Mockery::mock(RecipeService::class);
    $this->service = new RatingService($this->ratingRepository, $this->recipeService);
});

describe('rateRecipe', function () {
    test('cria avaliação com sucesso quando receita existe', function () {
        $rating = Mockery::mock(Rating::class);
        
        $this->recipeService
            ->shouldReceive('recipeExists')
            ->once()
            ->with(1)
            ->andReturn(true);
        
        $this->ratingRepository
            ->shouldReceive('createOrUpdate')
            ->once()
            ->with([
                'recipe_id' => 1,
                'user_id' => 2,
                'score' => 5,
            ])
            ->andReturn($rating);
        
        $result = $this->service->rateRecipe(1, 2, 5);
        
        expect($result)->toBe($rating);
    });

    test('atualiza avaliação existente', function () {
        $rating = Mockery::mock(Rating::class);
        
        $this->recipeService
            ->shouldReceive('recipeExists')
            ->once()
            ->with(1)
            ->andReturn(true);
        
        $this->ratingRepository
            ->shouldReceive('createOrUpdate')
            ->once()
            ->with([
                'recipe_id' => 1,
                'user_id' => 2,
                'score' => 4,
            ])
            ->andReturn($rating);
        
        $result = $this->service->rateRecipe(1, 2, 4);
        
        expect($result)->toBe($rating);
    });

    test('lança exceção quando receita não existe', function () {
        $this->recipeService
            ->shouldReceive('recipeExists')
            ->once()
            ->with(999)
            ->andReturn(false);
        
        $this->ratingRepository
            ->shouldNotReceive('createOrUpdate');
        
        $this->service->rateRecipe(999, 2, 5);
    })->throws(InvalidArgumentException::class, 'Receita com ID 999 não encontrada.');

    test('aceita diferentes valores de score', function ($score) {
        $rating = Mockery::mock(Rating::class);
        
        $this->recipeService
            ->shouldReceive('recipeExists')
            ->once()
            ->with(1)
            ->andReturn(true);
        
        $this->ratingRepository
            ->shouldReceive('createOrUpdate')
            ->once()
            ->with([
                'recipe_id' => 1,
                'user_id' => 2,
                'score' => $score,
            ])
            ->andReturn($rating);
        
        $result = $this->service->rateRecipe(1, 2, $score);
        
        expect($result)->toBe($rating);
    })->with([1, 2, 3, 4, 5]);
});

describe('hasUserRated', function () {
    test('retorna true quando usuário já avaliou', function () {
        $this->ratingRepository
            ->shouldReceive('userHasRated')
            ->once()
            ->with(1, 2)
            ->andReturn(true);
        
        $result = $this->service->hasUserRated(1, 2);
        
        expect($result)->toBeTrue();
    });

    test('retorna false quando usuário não avaliou', function () {
        $this->ratingRepository
            ->shouldReceive('userHasRated')
            ->once()
            ->with(1, 2)
            ->andReturn(false);
        
        $result = $this->service->hasUserRated(1, 2);
        
        expect($result)->toBeFalse();
    });
});

describe('getUserRating', function () {
    test('retorna avaliação do usuário quando existe', function () {
        $rating = Mockery::mock(Rating::class);
        
        $this->ratingRepository
            ->shouldReceive('findByUserAndRecipe')
            ->once()
            ->with(1, 2)
            ->andReturn($rating);
        
        $result = $this->service->getUserRating(1, 2);
        
        expect($result)->toBe($rating);
    });

    test('retorna null quando usuário não tem avaliação', function () {
        $this->ratingRepository
            ->shouldReceive('findByUserAndRecipe')
            ->once()
            ->with(1, 2)
            ->andReturn(null);
        
        $result = $this->service->getUserRating(1, 2);
        
        expect($result)->toBeNull();
    });
});
