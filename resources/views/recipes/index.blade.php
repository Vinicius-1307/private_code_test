@extends('layouts.app')

@section('title', 'Receitas')

@section('content')
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">
                <i class="bi bi-book"></i> Minhas Receitas
            </h1>
            @auth
                <a href="{{ route('recipes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Nova Receita
                </a>
            @endauth
        </div>

        @if ($recipes->count() > 0)
            <div class="row g-4">
                @foreach ($recipes as $recipe)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3">
                                    <a href="{{ route('recipes.show', $recipe) }}" class="text-decoration-none text-dark">
                                        {{ $recipe->title }}
                                    </a>
                                </h5>

                                @if ($recipe->description)
                                    <p class="card-text text-muted">
                                        {{ Str::limit($recipe->description, 100) }}
                                    </p>
                                @endif

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-person"></i> {{ $recipe->user->name }}
                                    </small>
                                    <div>
                                        @if ($recipe->ratings_count > 0)
                                            <span class="badge badge-rating">
                                                <i class="bi bi-star-fill"></i>
                                                {{ number_format($recipe->ratings_avg_score, 1) }}
                                                ({{ $recipe->ratings_count }})
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                Sem avaliações
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i> {{ $recipe->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-eye"></i> Ver Receita
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $recipes->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h3 class="mt-3 text-muted">Nenhuma receita encontrada</h3>
                @auth
                    <p class="text-muted">Seja o primeiro a compartilhar uma receita!</p>
                    <a href="{{ route('recipes.create') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-lg"></i> Criar Primeira Receita
                    </a>
                @endauth
            </div>
        @endif
    </div>
@endsection
