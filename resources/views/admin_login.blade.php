@extends('layouts.app')

@section('title', 'Login Administrativo - Elegance Joias')

@section('content')
<div class="container">
    <div style="max-width: 450px; margin: 60px auto; padding: 40px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="text-align: center; margin-bottom: 30px;">
            <i class="fas fa-shield-alt" style="font-size: 3rem; color: var(--color-primary); margin-bottom: 1rem;"></i>
            <h1 style="font-size: 1.8rem; margin-bottom: 0.5rem;">Área Administrativa</h1>
            <p style="color: #666; font-size: 0.95rem;">Acesso restrito a administradores</p>
        </div>

        @if ($errors->any())
            <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                <strong>Erro:</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        @if(session('message'))
            <div style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label for="email" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">E-mail Administrativo</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;"
                       placeholder="admin@elegancejoias.com">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="password" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">Senha</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password" required
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;"
                           placeholder="••••••••">
                    <button type="button" onclick="togglePassword('password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #666; font-size: 1.2rem;">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="remember" style="margin-right: 8px;">
                    <span style="color: #666; font-size: 0.95rem;">Lembrar-me por 30 dias</span>
                </label>
            </div>

            <button type="submit" class="btn btn-dark" style="width: 100%; padding: 14px; font-size: 1rem; font-weight: 600;">
                <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
                Acessar Painel Administrativo
            </button>
        </form>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; text-align: center;">
            <p style="color: #999; font-size: 0.9rem; margin-bottom: 10px;">
                <i class="fas fa-info-circle"></i> Não é administrador?
            </p>
            <a href="{{ route('login') }}" style="color: var(--color-primary); text-decoration: none; font-weight: 500;">
                Fazer login como cliente
            </a>
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <a href="{{ route('index') }}" style="color: #999; text-decoration: none; font-size: 0.9rem;">
                <i class="fas fa-arrow-left"></i> Voltar para a loja
            </a>
        </div>
    </div>
</div>

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
