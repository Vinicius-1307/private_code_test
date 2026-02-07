@extends('layouts.app')

@section('title', 'Editar Receita')

@section('content')
    <div class="content-wrapper">
        <button onclick="window.history.back()" class="btn btn-link text-decoration-none text-muted p-0 mb-3">
            <i class="bi bi-arrow-left"></i> Voltar
        </button>
        <h1 class="fw-bold mb-4">
            <i class="bi bi-pencil"></i> Editar Receita
        </h1>

        <form method="POST" action="{{ route('recipes.update', $recipe) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="form-label fw-bold">Título da Receita *</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    name="title" value="{{ old('title', $recipe->title) }}" placeholder="Ex: Bolo de Chocolate" required
                    maxlength="120">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Mínimo 3 e máximo 120 caracteres</div>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label fw-bold">Descrição (opcional)</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                    rows="3" placeholder="Breve descrição sobre a receita...">{{ old('description', $recipe->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Ingredientes *</label>
                <div id="ingredients-container">
                    @php
                        $ingredients = old('ingredients', $recipe->ingredients);
                    @endphp
                    @foreach ($ingredients as $index => $ingredient)
                        <div class="input-group mb-2 ingredient-item">
                            <span class="input-group-text"><i class="bi bi-check2"></i></span>
                            <input type="text" class="form-control @error("ingredients.$index") is-invalid @enderror"
                                name="ingredients[]" value="{{ $ingredient }}"
                                placeholder="Ex: 2 xícaras de farinha de trigo" required>
                            <button class="btn btn-outline-danger remove-ingredient" type="button">
                                <i class="bi bi-trash"></i>
                            </button>
                            @error("ingredients.$index")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-outline-primary" id="add-ingredient">
                    <i class="bi bi-plus-lg"></i> Adicionar Ingrediente
                </button>
                @error('ingredients')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="steps" class="form-label fw-bold">Modo de Preparo *</label>
                <textarea class="form-control @error('steps') is-invalid @enderror" id="steps" name="steps" rows="8"
                    placeholder="Descreva o passo a passo para preparar a receita..." required>{{ old('steps', $recipe->steps) }}</textarea>
                @error('steps')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Atualizar Receita
                </button>
                <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('ingredients-container');
                const addButton = document.getElementById('add-ingredient');

                // Adicionar novo ingrediente
                addButton.addEventListener('click', function() {
                    const newItem = document.createElement('div');
                    newItem.className = 'input-group mb-2 ingredient-item';
                    newItem.innerHTML = `
            <span class="input-group-text"><i class="bi bi-check2"></i></span>
            <input type="text" 
                   class="form-control" 
                   name="ingredients[]" 
                   placeholder="Ex: 2 xícaras de farinha de trigo"
                   required>
            <button class="btn btn-outline-danger remove-ingredient" type="button">
                <i class="bi bi-trash"></i>
            </button>
        `;
                    container.appendChild(newItem);
                    updateRemoveButtons();
                });

                // Remover ingrediente
                container.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-ingredient')) {
                        e.target.closest('.ingredient-item').remove();
                        updateRemoveButtons();
                    }
                });

                // Atualizar estado dos botões de remover
                function updateRemoveButtons() {
                    const items = container.querySelectorAll('.ingredient-item');
                    items.forEach((item, index) => {
                        const button = item.querySelector('.remove-ingredient');
                        button.disabled = items.length === 1;
                    });
                }

                updateRemoveButtons();
            });
        </script>
    @endpush
@endsection
