@extends('layouts.app')

@section('title', 'Login - Elegance Joias')

@section('content')
<div class="container">
        <button class="btn-back" data-history-back style="margin-bottom: 15px;">Voltar</button>
        <nav class="breadcrumb">
            <a href="{{ route('index') }}">Página Inicial</a>
            <span>&gt;</span>
            <span class="current">Login</span>
        </nav>

        <div class="auth-page-container">
            <form class="auth-form" id="loginForm">
                <h1>Entrar na Sua Conta</h1>
                <div class="auth-field">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" class="input-field" placeholder="seu@email.com" required>
                </div>
                <div class="auth-field">
                    <label for="login-password">Senha</label>
                    <input type="password" id="login-password" class="input-field" placeholder="••••••" required>
                </div>
                
                <p class="auth-link">É administrador? <a href="{{ route('adm-dashboard') }}">Entre no portal!</a></p>
                <p class="auth-link">Não tem conta? <a href="{{ route('cadastro') }}">Cadastre-se aqui!</a></p>
                <button type="submit" class="btn btn-dark" style="width: 100%; margin-top: 20px;">Entrar</button>
            </form>
    </div>
</div>

@include('partials.contact')
@endsection