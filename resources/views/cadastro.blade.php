@extends('layouts.app')

@section('title', 'Cadastro - Elegance Joias')

@section('content')
<div class="container">

    <button class="btn-back" data-history-back style="margin-bottom: 15px;">Voltar</button>
    <nav class="breadcrumb">
        <a href="{{ route('index') }}">Página Inicial</a>
        <span>&gt;</span>
        <span class="current">Cadastro</span>
    </nav>

    <div class="auth-page-container">
        <form class="auth-form" id="registerForm">
            <h1>Criar Conta</h1>
            <div class="auth-field">
                <label for="register-name">Nome Completo</label>
                <input type="text" id="register-name" placeholder="Seu nome" class="input-field" required>
            </div>
            <div class="auth-field">
                <label for="register-email">Email</label>
                <input type="email" id="register-email" placeholder="seu@email.com" class="input-field" required>
            </div>
            <div class="auth-field">
                <label for="register-password">Senha</label>
                <div style="position: relative;">
                    <input type="password" id="register-password" placeholder="••••••" class="input-field" required>
                    <button type="button" onclick="togglePassword('register-password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #666; font-size: 1.2rem;">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
                <div class="auth-field">
                    <label for="register-password-confirm">Confirmar Senha</label>
                    <div style="position: relative;">
                        <input type="password" id="register-password-confirm" placeholder="••••••" class="input-field" required>
                        <button type="button" onclick="togglePassword('register-password-confirm', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #666; font-size: 1.2rem;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <p class="auth-link">Já tem conta? <a href="{{ route('login') }}">Faça login!</a></p>
                <button type="submit" class="btn btn-dark" style="width: 100%; margin-top: 20px;">Cadastrar</button>
            </form>
        </div>
    </main>

    <section class="contact-section"><div class="content"><h2>Entre em contato com a gente caso tenha alguma dúvida ou sugestão! :) <h2>

        <form action="{{ route('suporte') }}" method="POST"><div class="input-wrapper"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        <input type="email" placeholder="Digite seu email" class="input-field" name="email">
    </div>

    <div class="input-wrapper">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
        <input type="text" placeholder="Conte para gente sua questão!" class="input-field">
    </div>
        <button type="submit" class="btn-submit">Enviar</button>
    </form>
</div>
</section>

@include('partials.contact')

<script>
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
