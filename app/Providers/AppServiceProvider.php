<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Recipe;
use App\Policies\CommentPolicy;
use App\Policies\RecipePolicy;
use App\Repositories\CommentRepository;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\RatingRepositoryInterface;
use App\Repositories\Interfaces\RecipeRepositoryInterface;
use App\Repositories\RatingRepository;
use App\Repositories\RecipeRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar bindings dos Repositories
        $this->app->bind(RecipeRepositoryInterface::class, RecipeRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(RatingRepositoryInterface::class, RatingRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Recipe::class, RecipePolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);
    }
}
