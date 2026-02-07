@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="fw-bold mb-4 text-center">
                <i class="bi bi-box-arrow-in-right"></i> Entrar
            </h1>

            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus>
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
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right"></i> Entrar
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="text-muted mb-2">Ainda não tem uma conta?</p>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary">
                            <i class="bi bi-person-plus"></i> Criar conta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
