@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
    <div class="content-wrapper">
        <button onclick="window.history.back()" class="btn btn-link text-decoration-none text-muted p-0 mb-3">
            <i class="bi bi-arrow-left"></i> Voltar
        </button>
        
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="fw-bold mb-2">{{ $recipe->title }}</h1>
                    <p class="text-muted mb-3">
                        <i class="bi bi-person"></i> Por {{ $recipe->user->name }} •
                        <i class="bi bi-clock"></i> {{ $recipe->created_at->format('d/m/Y') }}
                    </p>
                </div>

                @can('update', $recipe)
                    <div class="d-flex gap-2">
                        <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>
                        <form method="POST" action="{{ route('recipes.destroy', $recipe) }}"
                            onsubmit="return confirm('⚠️ Tem certeza que deseja deletar esta receita? Esta ação não pode ser desfeita.')"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash3"></i> Deletar
                            </button>
                        </form>
                    </div>
                @endcan
            </div>

            <div class="mb-4">
                @if ($recipe->ratings_count > 0)
                    <div class="d-flex align-items-center">
                        <span class="badge badge-rating fs-5 me-2">
                            <i class="bi bi-star-fill"></i>
                            {{ number_format($recipe->ratings_avg_score, 1) }}
                        </span>
                        <span class="text-muted">
                            ({{ $recipe->ratings_count }} {{ $recipe->ratings_count === 1 ? 'avaliação' : 'avaliações' }})
                        </span>
                    </div>
                @else
                    <span class="badge bg-secondary">Sem avaliações ainda</span>
                @endif
            </div>
        </div>

        @if ($recipe->description)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-info-circle"></i> Descrição</h5>
                    <p class="card-text">{{ $recipe->description }}</p>
                </div>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-basket"></i> Ingredientes</h5>
                <ul class="list-group list-group-flush">
                    @foreach ($recipe->ingredients as $ingredient)
                        <li class="list-group-item">
                            <i class="bi bi-check2"></i> {{ $ingredient }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-list-ol"></i> Modo de Preparo</h5>
                <div class="card-text" style="white-space: pre-line;">{{ $recipe->steps }}</div>
            </div>
        </div>

        @auth
            @if ($recipe->user_id !== auth()->id())
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-star"></i> Avaliar esta receita</h5>

                        @if ($userRating)
                            <div class="alert alert-success d-flex align-items-center">
                                <div>
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <strong>Você já avaliou esta receita!</strong>
                                    <div class="mt-2">
                                        Sua avaliação:
                                        <span class="badge badge-rating">
                                            <i class="bi bi-star-fill"></i> {{ $userRating->score }}
                                        </span>
                                        <small class="text-muted ms-2">
                                            em {{ $userRating->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form method="POST" action="{{ route('recipes.ratings.store', $recipe) }}">
                                @csrf
                                <div class="d-flex align-items-center gap-3">
                                    <div class="btn-group" role="group">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <input type="radio" class="btn-check" name="score"
                                                id="rating{{ $i }}" value="{{ $i }}" required>
                                            <label class="btn btn-outline-warning" for="rating{{ $i }}">
                                                <i class="bi bi-star-fill"></i> {{ $i }}
                                            </label>
                                        @endfor
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send"></i> Enviar Avaliação
                                    </button>
                                </div>
                                @error('score')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        @endauth

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-chat-dots"></i>
                    Comentários ({{ $recipe->comments->count() }})
                </h5>

                @auth
                    <form method="POST" action="{{ route('recipes.comments.store', $recipe) }}" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="3"
                                placeholder="Deixe seu comentário..." required></textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Comentar
                        </button>
                    </form>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <a href="{{ route('login') }}">Faça login</a> para comentar nesta receita.
                    </div>
                @endauth

                @if ($recipe->comments->count() > 0)
                    <div class="mt-4">
                        @foreach ($recipe->comments as $comment)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-0">
                                            <i class="bi bi-person-circle"></i> {{ $comment->user->name }}
                                        </h6>
                                        <small class="text-muted">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <p class="mb-0">{{ $comment->body }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center mt-4">Nenhum comentário ainda. Seja o primeiro!</p>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('recipes.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Voltar para receitas
            </a>
        </div>
    </div>
@endsection
