@extends('layouts.app')

@section('title', 'Registrar')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="fw-bold mb-4 text-center">
                <i class="bi bi-person-plus"></i> Criar Conta
            </h1>

            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Mínimo de 8 caracteres</div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-person-plus"></i> Criar Conta
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="text-muted mb-2">Já tem uma conta?</p>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Entrar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
