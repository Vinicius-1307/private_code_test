<?php

use App\Models\Recipe;
use App\Repositories\Interfaces\RecipeRepositoryInterface;
use App\Services\RecipeService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

beforeEach(function () {
    $this->repository = Mockery::mock(RecipeRepositoryInterface::class);
    $this->service = new RecipeService($this->repository);
});

describe('listRecipes', function () {
    test('retorna receitas paginadas do repositório', function () {
        $paginator = Mockery::mock(LengthAwarePaginator::class);

        $this->repository
            ->shouldReceive('getAllWithRelations')
            ->once()
            ->with(15)
            ->andReturn($paginator);

        $result = $this->service->listRecipes();

        expect($result)->toBe($paginator);
    });

    test('aceita parâmetro de paginação personalizado', function () {
        $paginator = Mockery::mock(LengthAwarePaginator::class);

        $this->repository
            ->shouldReceive('getAllWithRelations')
            ->once()
            ->with(25)
            ->andReturn($paginator);

        $result = $this->service->listRecipes(25);

        expect($result)->toBe($paginator);
    });
});

describe('getRecipe', function () {
    test('retorna receita encontrada', function () {
        $recipe = Mockery::mock(Recipe::class);

        $this->repository
            ->shouldReceive('findWithRelations')
            ->once()
            ->with(1)
            ->andReturn($recipe);

        $result = $this->service->getRecipe(1);

        expect($result)->toBe($recipe);
    });

    test('retorna null quando receita não existe', function () {
        $this->repository
            ->shouldReceive('findWithRelations')
            ->once()
            ->with(999)
            ->andReturn(null);

        $result = $this->service->getRecipe(999);

        expect($result)->toBeNull();
    });
});

describe('createRecipe', function () {
    test('cria receita com dados fornecidos e userId', function () {
        $data = [
            'title' => 'Bolo de Chocolate',
            'description' => 'Delicioso bolo',
        ];

        $recipe = Mockery::mock(Recipe::class);

        $this->repository
            ->shouldReceive('create')
            ->once()
            ->with([
                'title' => 'Bolo de Chocolate',
                'description' => 'Delicioso bolo',
                'user_id' => 1,
            ])
            ->andReturn($recipe);

        $result = $this->service->createRecipe($data, 1);

        expect($result)->toBe($recipe);
    });
});

describe('updateRecipe', function () {
    test('atualiza receita com sucesso', function () {
        $recipe = Mockery::mock(Recipe::class);
        $data = ['title' => 'Bolo Atualizado'];

        $this->repository
            ->shouldReceive('update')
            ->once()
            ->with($recipe, $data)
            ->andReturn(true);

        $result = $this->service->updateRecipe($recipe, $data);

        expect($result)->toBeTrue();
    });

    test('retorna false quando atualização falha', function () {
        $recipe = Mockery::mock(Recipe::class);
        $data = ['title' => 'Bolo Atualizado'];

        $this->repository
            ->shouldReceive('update')
            ->once()
            ->with($recipe, $data)
            ->andReturn(false);

        $result = $this->service->updateRecipe($recipe, $data);

        expect($result)->toBeFalse();
    });
});

describe('deleteRecipe', function () {
    test('deleta receita com sucesso', function () {
        $recipe = Mockery::mock(Recipe::class);

        $this->repository
            ->shouldReceive('delete')
            ->once()
            ->with($recipe)
            ->andReturn(true);

        $result = $this->service->deleteRecipe($recipe);

        expect($result)->toBeTrue();
    });

    test('retorna false quando exclusão falha', function () {
        $recipe = Mockery::mock(Recipe::class);

        $this->repository
            ->shouldReceive('delete')
            ->once()
            ->with($recipe)
            ->andReturn(false);

        $result = $this->service->deleteRecipe($recipe);

        expect($result)->toBeFalse();
    });
});

describe('getUserRecipes', function () {
    test('retorna receitas do usuário', function () {
        $recipes = new Collection([
            Mockery::mock(Recipe::class),
            Mockery::mock(Recipe::class),
        ]);

        $this->repository
            ->shouldReceive('getByUser')
            ->once()
            ->with(1)
            ->andReturn($recipes);

        $result = $this->service->getUserRecipes(1);

        expect($result)->toBe($recipes);
    });
});

describe('recipeExists', function () {
    test('retorna true quando receita existe', function () {
        $this->repository
            ->shouldReceive('exists')
            ->once()
            ->with(1)
            ->andReturn(true);

        $result = $this->service->recipeExists(1);

        expect($result)->toBeTrue();
    });

    test('retorna false quando receita não existe', function () {
        $this->repository
            ->shouldReceive('exists')
            ->once()
            ->with(999)
            ->andReturn(false);

        $result = $this->service->recipeExists(999);

        expect($result)->toBeFalse();
    });
});
