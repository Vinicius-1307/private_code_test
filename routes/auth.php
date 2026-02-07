<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rotas de Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    $credentials = request()->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        request()->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
    ])->onlyInput('email');
});

// Rotas de Registro
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function () {
    $validated = request()->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ], [
        'name.required' => 'O campo nome é obrigatório.',
        'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',
        'email.required' => 'O campo e-mail é obrigatório.',
        'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
        'email.unique' => 'Este e-mail já está em uso.',
        'password.required' => 'O campo senha é obrigatório.',
        'password.min' => 'O campo senha deve ter pelo menos 8 caracteres.',
        'password.confirmed' => 'A confirmação da senha não confere.',
    ]);

    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
    ]);

    Auth::login($user);

    return redirect('/');
});

// Rota de Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
