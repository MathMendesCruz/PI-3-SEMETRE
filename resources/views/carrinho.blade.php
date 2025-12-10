@extends('layouts.app')

@section('title', 'Carrinho - Elegance Joias')

@section('content')
    @if(!auth()->check())
        <div class="container">
            <nav class="breadcrumb">
                <a href="{{ route('index') }}">Página Inicial</a>
                <span>&gt;</span>
                <span class="current">Carrinho</span>
            </nav>

            <div style="text-align: center; padding: 60px 20px;">
                <h1 class="section-title">Acesso Negado</h1>
                <p class="text-secondary" style="font-size: 16px; margin-bottom: 30px;">
                    Para acessar o carrinho, você precisa estar logado na sua conta.
                </p>
                <a href="{{ route('login') }}" class="btn btn-dark">Fazer Login</a>
                <span class="auth-divider">ou</span>
                <a href="{{ route('cadastro') }}" class="btn btn-outline">Criar Conta</a>
            </div>
        </div>
    @else
        <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <button class="btn-back" data-history-back>Voltar</button>
            <nav class="breadcrumb">
                <a href="{{ route('index') }}">Página Inicial</a>
                <span>&gt;</span>
                <span class="current">Carrinho</span>
            </nav>
        </div>

        <h1 class="section-title" style="text-align: left; margin-top: 0; margin-bottom: var(--space-xl);">Seu carrinho</h1>

        <div class="cart-layout">
            <section class="cart-items" id="cart-items">
                <!-- Carrinho carregado dinamicamente via JavaScript -->
                <div style="text-align: center; padding: 40px; color: #999;">
                    <p>Carregando carrinho...</p>
                </div>
            </section>

            <aside class="cart-summary">
            <h2>Resumo</h2>
            <div class="summary-row">
                <span>Subtotal</span>
                <span class="value" id="subtotal">R$ 0,00</span>
            </div>
            <div class="summary-row">
                <span id="discount-label">Desconto</span>
                <span class="value discount" id="discount">-R$ 0,00</span>
            </div>

            <hr>

            <div class="shipping-calculator">
                <label for="cep-input" class="shipping-label">Calcular Frete</label>
                <form class="cep-form" id="cep-form">
                    <input type="text" id="cep-input" placeholder="Digite seu CEP" maxlength="9">
                    <button type="submit" id="calculate-shipping-btn">Calcular</button>
                </form>

                <p class="shipping-message" id="shipping-message"></p>
            </div>

            <div class="summary-row shipping-row">
                <span>Frete</span>

                <span class="value" id="shipping-value">--</span>
            </div>
            <hr>

            <div class="summary-row total-row">
                <span>Total</span>
                <span class="value" id="total">R$ 0,00</span>
            </div>

            <form class="coupon-form" id="coupon-form">
                <input type="text" id="coupon-input" placeholder="Adicionar cupom">
                <button type="submit">Aplicar</button>
            </form>
            <p class="coupon-message" id="coupon-message"></p>

            <button class="btn btn-dark btn-checkout" onclick="window.location.href='{{ route('checkout') }}'">
                Finalizar Compra &rarr;
            </button>
        </aside>
        </div>
        </div>

        @include('partials.contact')
    @endif
@endsection
