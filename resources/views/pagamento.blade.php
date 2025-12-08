@extends('layouts.app')
@section('title', 'Pagamento - Joalheria')
@section('content')

    @if(!auth()->check())
        <div class="container">
            <nav class="breadcrumb">
                <a href="{{ route('index') }}">Página Inicial</a>
                <span>&gt;</span>
                <span class="current">Pagamento</span>
            </nav>
            
            <div style="text-align: center; padding: 60px 20px;">
                <h1 class="section-title">Acesso Negado</h1>
                <p class="text-secondary" style="font-size: 16px; margin-bottom: 30px;">
                    Para finalizar a compra, você precisa estar logado na sua conta.
                </p>
                <a href="{{ route('login') }}" class="btn btn-dark">Fazer Login</a>
                <span class="auth-divider">ou</span>
                <a href="{{ route('cadastro') }}" class="btn btn-outline">Criar Conta</a>
            </div>
        </div>
    @else
    <div class="container">
        <button class="btn-back" data-history-back style="margin-bottom: 15px;">Voltar</button>
        <nav class="breadcrumb">
            <a href="{{ route('index') }}">Página Inicial</a>
            <span>&gt;</span>
            <a href="{{ route('produto', ['id' => 1]) }}">Anel de...</a>
             <span>&gt;</span>
            <a href="{{ route('carrinho') }}">Carrinho</a>
             <span>&gt;</span>
            <span class="current">Pagamento</span>
        </nav>

        <div class="checkout-layout">
            
            <section class="checkout-summary">
                <h1 class="checkout-title">Resumo</h1>

                <div class="payment-modal-overlay" id="payment-overlay"></div>
                <div class="payment-modal" id="payment-modal">
                    <svg class="modal-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3>Pagamento confirmado!</h3>
                </div>
                <div class="cart-items">
                     <article class="cart-item" data-price="145.50"><div class="item-details"><img src="{{ asset('img/anel1.png') }}" 
                       alt="Colar de Ouro"><div><h2>Colar de Ouro</h2><p>Tamanho: 45 cm</p><p>Cor: Ouro</p><p class="price">R$145,50</p></div></div><div class="item-controls"><div class="quantity-selector"><button class="decrease-qty">-</button><span class="quantity-value">1</span><button class="increase-qty">+</button></div><button class="delete-item-btn" title="Remover"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg></button></div></article>

                     <article class="cart-item" data-price="180.45"><div class="item-details"><img src="{{ asset('img/anel2.png') }}" 
                        alt="Colar de Ouro"><div><h2>Colar de Ouro</h2><p>Tamanho: 45 cm</p><p>Cor: Ouro</p><p class="price">R$180,45</p></div></div><div class="item-controls"><div class="quantity-selector"><button class="decrease-qty">-</button><span class="quantity-value">1</span><button class="increase-qty">+</button></div><button class="delete-item-btn" title="Remover"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg></button></div></article>

                     <article class="cart-item" data-price="240.25"><div class="item-details"><img src="{{ asset('img/colar2.png') }}" 
                        alt="Colar de Ouro"><div><h2>Colar de Ouro</h2><p>Tamanho: 40 cm</p><p>Cor: Ouro</p><p class="price">R$240,25</p></div></div><div class="item-controls"><div class="quantity-selector"><button class="decrease-qty">-</button><span class="quantity-value">1</span><button class="increase-qty">+</button></div><button class="delete-item-btn" title="Remover"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg></button></div></article>
                </div>
            </section>
            
            <aside class="checkout-payment">
                <a href="{{ route('carrinho') }}" class="back-link">&larr; Voltar </a>
                <h1 class="checkout-title payment">Pagamento</h1>

                <div class="payment-item-summary">
                    <span>Item</span>
                    <span>Colar de Ouro</span>
                    <span>x5</span> </div>

                <div class="cart-summary payment-page">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="subtotal" class="value">R$565,89</span>
                    </div>
                    <div class="summary-row">
                        <span id="discount-label">Desconto</span> 
                        <span id="discount" class="discount">-R$0,00</span>
                    </div>
                    <div class="summary-row">
                        <span>Frete</span>
                        <span id="shipping" class="value">R$15,99</span>
                    </div>
                    <hr>
                    <div class="summary-row total-row">
                        <span>Total</span>
                        <span id="total">R$4.567,85</span>
                    </div>
                </div>

                <div class="payment-timer-container">
                    <span>Tempo restante para concluir:</span>
                    <span id="payment-timer" class="payment-timer-time">10:00</span>
                </div>
                <h3 class="payment-methods-title">Forma de pagamento</h3>
                <form id="payment-form">
                    <div class="payment-methods">
                        <div class="payment-option">
                            <input type="radio" name="paymentMethod" value="visa-1234" id="visa-1234" checked>
                            <label for="visa-1234" class="payment-method">
                                <span>VISA</span>
                                <span>************2109</span>
                            </label>
                        </div>

                        <div class="payment-option">
                            <input type="radio" name="paymentMethod" value="paypal-5678" id="paypal-5678">
                            <label for="paypal-5678" class="payment-method">
                                <span>PayPal</span>
                                <span>************2109</span>
                            </label>
                        </div>

                        <div class="payment-option">
                            <input type="radio" name="paymentMethod" value="pix" id="pix">
                            <label for="pix" class="payment-method pix-option">
                                <span>PIX</span>
                                </label>
                        </div>

                        <button type="button" class="payment-method add-card-btn" id="add-card-btn">
                            <span>+</span>
                            <span>Cadastrar novo cartão</span>
                        </button>

                    </div>

                    <button type="submit" class="btn btn-dark" id="continue-btn" style="width: 100%; background-color: var(--color-primary); color: var(--color-dark);">Continue</button>
                </form>

                

            </aside>
        </div>
    </div>
    @include('partials.contact')
    @endif
@endsection