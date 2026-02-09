<?php

use App\Models\Recipe;
use App\Repositories\RecipeRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

beforeEach(function () {
    $this->model = Mockery::mock(Recipe::class);
    $this->repository = new RecipeRepository($this->model);
});

describe('getAllWithRelations', function () {
    test('retorna receitas paginadas com relacionamentos e agregações', function () {
        $query = Mockery::mock();
        $paginator = Mockery::mock(LengthAwarePaginator::class);
        
        $this->model
            ->shouldReceive('with')
            ->once()
            ->with('user:id,name')
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('withRatingsAggregate')
            ->once()
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('orderBy')
            ->once()
            ->with('created_at', 'desc')
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('paginate')
            ->once()
            ->with(15)
            ->andReturn($paginator);
        
        $result = $this->repository->getAllWithRelations();
        
        expect($result)->toBe($paginator);
    });

    test('aceita parâmetro de paginação personalizado', function () {
        $paginator = Mockery::mock(LengthAwarePaginator::class);
        
        $this->model
            ->shouldReceive('with')
            ->once()
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('withRatingsAggregate')
            ->once()
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('orderBy')
            ->once()
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('paginate')
            ->once()
            ->with(30)
            ->andReturn($paginator);
        
        $result = $this->repository->getAllWithRelations(30);
        
        expect($result)->toBe($paginator);
    });
});

describe('findWithRelations', function () {
    test('retorna receita com relacionamentos completos', function () {
        $recipe = Mockery::mock(Recipe::class);
        
        $this->model
            ->shouldReceive('with')
            ->once()
            ->with(Mockery::on(function ($arg) {
                return is_array($arg) 
                    && isset($arg[0]) 
                    && $arg[0] === 'user:id,name'
                    && isset($arg['comments'])
                    && is_callable($arg['comments']);
            }))
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('withRatingsAggregate')
            ->once()
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($recipe);
        
        $result = $this->repository->findWithRelations(1);
        
        expect($result)->toBe($recipe);
    });

    test('retorna null quando receita não existe', function () {
        $this->model
            ->shouldReceive('with')
            ->once()
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('withRatingsAggregate')
            ->once()
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('find')
            ->once()
            ->with(999)
            ->andReturn(null);
        
        $result = $this->repository->findWithRelations(999);
        
        expect($result)->toBeNull();
    });
});

describe('create', function () {
    test('cria nova receita', function () {
        $data = [
            'user_id' => 1,
            'title' => 'Bolo de Chocolate',
            'description' => 'Delicioso bolo',
            'ingredients' => 'Chocolate, farinha, açúcar',
            'instructions' => 'Misture tudo e asse',
        ];
        
        $recipe = Mockery::mock(Recipe::class);
        
        $this->model
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($recipe);
        
        $result = $this->repository->create($data);
        
        expect($result)->toBe($recipe);
    });
});

describe('update', function () {
    test('atualiza receita existente', function () {
        $recipe = Mockery::mock(Recipe::class);
        $data = ['title' => 'Bolo Atualizado'];
        
        $recipe
            ->shouldReceive('update')
            ->once()
            ->with($data)
            ->andReturn(true);
        
        $result = $this->repository->update($recipe, $data);
        
        expect($result)->toBeTrue();
    });
});

describe('delete', function () {
    test('deleta receita', function () {
        $recipe = Mockery::mock(Recipe::class);
        
        $recipe
            ->shouldReceive('delete')
            ->once()
            ->andReturn(true);
        
        $result = $this->repository->delete($recipe);
        
        expect($result)->toBeTrue();
    });
});

describe('getByUser', function () {
    test('retorna receitas do usuário', function () {
        $recipes = new Collection();
        
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('user_id', 1)
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('withRatingsAggregate')
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
            ->andReturn($recipes);
        
        $result = $this->repository->getByUser(1);
        
        expect($result)->toBe($recipes);
    });
});

describe('exists', function () {
    test('retorna true quando receita existe', function () {
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('id', 1)
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('exists')
            ->once()
            ->andReturn(true);
        
        $result = $this->repository->exists(1);
        
        expect($result)->toBeTrue();
    });

    test('retorna false quando receita não existe', function () {
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('id', 999)
            ->andReturnSelf();
        
        $this->model
            ->shouldReceive('exists')
            ->once()
            ->andReturn(false);
        
        $result = $this->repository->exists(999);
        
        expect($result)->toBeFalse();
    });
});
