<?php

use App\Models\Comment;
use App\Models\Recipe;
use App\Models\User;
use App\Policies\CommentPolicy;

beforeEach(function () {
    $this->policy = new CommentPolicy();
});

describe('delete', function () {
    test('permite exclusão quando usuário é o autor do comentário', function () {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 1;
        
        $recipe = Mockery::mock(Recipe::class)->makePartial();
        $recipe->user_id = 2;
        
        $comment = Mockery::mock(Comment::class)->makePartial();
        $comment->user_id = 1;
        $comment->shouldReceive('getAttribute')
            ->with('recipe')
            ->andReturn($recipe);
        
        $result = $this->policy->delete($user, $comment);
        
        expect($result)->toBeTrue();
    });

    test('permite exclusão quando usuário é o dono da receita', function () {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 1;
        
        $recipe = Mockery::mock(Recipe::class)->makePartial();
        $recipe->user_id = 1;
        
        $comment = Mockery::mock(Comment::class)->makePartial();
        $comment->user_id = 2;
        $comment->shouldReceive('getAttribute')
            ->with('recipe')
            ->andReturn($recipe);
        
        $result = $this->policy->delete($user, $comment);
        
        expect($result)->toBeTrue();
    });

    test('permite exclusão quando usuário é tanto autor quanto dono', function () {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 1;
        
        $recipe = Mockery::mock(Recipe::class)->makePartial();
        $recipe->user_id = 1;
        
        $comment = Mockery::mock(Comment::class)->makePartial();
        $comment->user_id = 1;
        $comment->shouldReceive('getAttribute')
            ->with('recipe')
            ->andReturn($recipe);
        
        $result = $this->policy->delete($user, $comment);
        
        expect($result)->toBeTrue();
    });

    test('nega exclusão quando usuário não é autor nem dono da receita', function () {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 1;
        
        $recipe = Mockery::mock(Recipe::class)->makePartial();
        $recipe->user_id = 2;
        
        $comment = Mockery::mock(Comment::class)->makePartial();
        $comment->user_id = 3;
        $comment->shouldReceive('getAttribute')
            ->with('recipe')
            ->andReturn($recipe);
        
        $result = $this->policy->delete($user, $comment);
        
        expect($result)->toBeFalse();
    });

    test('nega exclusão para usuário aleatório', function () {
        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 10;
        
        $recipe = Mockery::mock(Recipe::class)->makePartial();
        $recipe->user_id = 5;
        
        $comment = Mockery::mock(Comment::class)->makePartial();
        $comment->user_id = 7;
        $comment->shouldReceive('getAttribute')
            ->with('recipe')
            ->andReturn($recipe);
        
        $result = $this->policy->delete($user, $comment);
        
        expect($result)->toBeFalse();
    });
});
