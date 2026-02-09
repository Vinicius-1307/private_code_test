<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('recipes.index');
});

Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');

Route::middleware('auth')->group(function () {
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

    Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])
        ->name('recipes.comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    Route::post('/recipes/{recipe}/ratings', [RatingController::class, 'store'])
        ->name('recipes.ratings.store');
});

Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

require __DIR__ . '/auth.php';
