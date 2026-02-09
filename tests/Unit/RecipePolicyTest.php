<?php

use App\Models\Recipe;
use App\Models\User;
use App\Policies\RecipePolicy;

beforeEach(function () {
    $this->policy = new RecipePolicy();
});

describe('update', function () {
    test('permite atualização quando usuário é o criador', function () {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 1;
        
        $recipe = Mockery::mock(Recipe::class)->makePartial();
        $recipe->user_id = 1;
        
        $result = $this->policy->update($user, $recipe);
        
        expect($result)->toBeTrue();
    });

    test('nega atualização quando usuário não é o criador', function () {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 1;
        
        $recipe = Mockery::mock(Recipe::class)->makePartial();
        $recipe->user_id = 2;
        
        $result = $this->policy->update($user, $recipe);
        
        expect($result)->toBeFalse();
    });

    test('nega atualização para usuário diferente', function () {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 5;
        
        $recipe = Mockery::mock(Recipe::class)->makePartial();
        $recipe->user_id = 10;
        
        $result = $this->policy->update($user, $recipe);
        
        expect($result)->toBeFalse();
    });
});

describe('delete', function () {
    test('permite exclusão quando usuário é o criador', function () {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 1;
        
        $recipe = Mockery::mock(Recipe::class)->makePartial();
        $recipe->user_id = 1;
        
        $result = $this->policy->delete($user, $recipe);
        
        expect($result)->toBeTrue();
    });

    test('nega exclusão quando usuário não é o criador', function () {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 1;
        
        $recipe = Mockery::mock(Recipe::class)->makePartial();
        $recipe->user_id = 2;
        
        $result = $this->policy->delete($user, $recipe);
        
        expect($result)->toBeFalse();
    });

    test('nega exclusão para usuário diferente', function () {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 3;
        
        $recipe = Mockery::mock(Recipe::class)->makePartial();
        $recipe->user_id = 7;
        
        $result = $this->policy->delete($user, $recipe);
        
        expect($result)->toBeFalse();
    });
});
