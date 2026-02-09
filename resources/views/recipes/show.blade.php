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
                        <x-confirm-delete 
                            action="{{ route('recipes.destroy', $recipe) }}"
                            title="Deletar receita?"
                            text="Tem certeza que deseja deletar '{{ $recipe->title }}'? Esta ação não pode ser desfeita."
                            confirmText="Sim, deletar!"
                            cancelText="Cancelar"
                            class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash3"></i>
                            <span>Deletar</span>
                        </x-confirm-delete>
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
                            <div class="bg-success bg-opacity-10 border border-success rounded-3 p-3 d-flex align-items-start">
                                <div class="text-success me-2" style="font-size: 1.5rem;">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div class="grow">
                                    <strong class="text-success">Você já avaliou esta receita!</strong>
                                    <div class="mt-2">
                                        <span class="text-muted">Sua avaliação:</span>
                                        <span class="badge badge-rating ms-1">
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
                    <div class="bg-info bg-opacity-10 border border-info rounded-3 p-3 d-flex align-items-center">
                        <div class="text-info me-2" style="font-size: 1.5rem;">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>
                        <div>
                            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Faça login</a> 
                            <span class="text-muted">para comentar nesta receita.</span>
                        </div>
                    </div>
                @endauth

                @if ($recipe->comments->count() > 0)
                    <div class="mt-4">
                        @foreach ($recipe->comments as $comment)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-0">
                                                <i class="bi bi-person-circle"></i> {{ $comment->user->name }}
                                            </h6>
                                            <small class="text-muted">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        @can('delete', $comment)
                                            <x-confirm-delete 
                                                action="{{ route('comments.destroy', $comment) }}"
                                                title="Deletar comentário?"
                                                text="Tem certeza que deseja remover este comentário?"
                                                confirmText="Sim, deletar!"
                                                cancelText="Cancelar"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash3"></i>
                                                <span>Deletar</span>
                                            </x-confirm-delete>
                                        @endcan
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
