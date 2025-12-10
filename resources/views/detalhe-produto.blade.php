@extends('layouts.app')

@section('title', 'Detalhes do Produto - Elegance Joias')

@section('content')

    <div class="container">
        <button class="btn-back" data-history-back style="margin-bottom: 15px;">Voltar</button>
        <nav class="breadcrumb">
            <a href="{{ route('index') }}">Página Inicial</a>
            <span>&gt;</span>
            <a href="{{ route('feminino') }}">Feminino</a>
            <span>&gt;</span>
            <span class="current">{{ $product->name }}</span>
        </nav>

        <section class="product-details-layout">
            <div class="product-gallery">
                <div class="main-image">
                    <img src="{{ asset('img/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         onerror="this.src='{{ asset('img/placeholder.svg') }}'">
                </div>
                <div class="thumbnail-images">
                    <img src="{{ asset('img/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         onerror="this.src='{{ asset('img/placeholder.svg') }}'">
                </div>
            </div>
            <div class="product-info" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}" data-product-image="{{ asset('img/' . $product->image) }}">
                <h1>{{ $product->name }}</h1>
                <div class="rating-price">
                    <div class="rating">
                        <span>4.5/5</span>
                    </div>
                    <p class="info-price">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                </div>
                <div class="stock-info">
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <p class="stock-details">
                            <strong>Estoque:</strong> <span class="stock-value">{{ $product->stock }} unidade(s)</span>
                        </p>
                    @else
                        <p class="stock-details">
                            <strong>Status:</strong> <span class="availability-status">
                                @if($product->stock > 0)
                                    <span class="text-success">✓ Disponível</span>
                                @else
                                    <span class="text-danger">✗ Indisponível</span>
                                @endif
                            </span>
                        </p>
                    @endif
                </div>
                <p class="description">
                    {{ $product->description ?? 'Descrição não disponível para este produto.' }}
                </p>
                <div class="color-selector">
                    <span class="color-swatch active" style="background-color: #d1d5db;" title="Prata"></span>
                    <span class="color-swatch" style="background-color: #fde047;" title="Ouro"></span>
                </div>
                <div class="controls">
                    <div class="quantity-selector">
                        <button class="qty-btn qty-minus" type="button">-</button>
                        <span class="quantity-value">1</span>
                        <button class="qty-btn qty-plus" type="button">+</button>
                    </div>
                    @if($product->stock > 0)
                        <button class="btn btn-dark add-to-cart-btn"
                                type="button"
                                onclick="addToCart({{ $product->id }}, parseInt(document.querySelector('.quantity-value').textContent))">
                            <i class="fas fa-shopping-cart"></i> Adicionar ao carrinho
                        </button>
                    @else
                        <button class="btn btn-dark"
                                type="button"
                                disabled
                                style="opacity: 0.6; cursor: not-allowed;">
                            Indisponível
                        </button>
                    @endif
                </div>
            </div>
        </section>

        <section class="product-tabs">
            <nav class="tabs-nav">
                <span class="tab-link" data-tab="detalhes">Detalhes</span>
                <span class="tab-link active" data-tab="comentarios">Comentários (183)</span>
                <span class="tab-link" data-tab="faqs">FAQs</span>
            </nav>
            <div class="tabs-content">
                <div class="tab-pane" id="detalhes">
                    <p>Aqui vão os detalhes técnicos do produto, como material, peso, dimensões, etc.</p>
                </div>
                <div class="tab-pane active" id="comentarios">
                    <div class="comments-header">
                        <div class="filters">
                            <button class="filter-btn">Filtrar</button>
                            <button class="filter-btn">Mais recentes</button>
                        </div>
                        <button class="btn btn-dark" id="open-comment-modal" style="border-radius: 5px; padding: 10px 20px;">Deixar um comentário</button>
                    </div>
                    <div class="comments-grid">
                        <div class="comment-card">
                            <div class="user-info">
                                <div class="user"><span>Samantha O.</span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></div>
                                <span class="options">...</span>
                            </div>
                            <div class="rating"><script>for(let i=0; i<5; i++) document.write('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>');</script></div>
                            <p class="comment-body">"Is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"</p>
                            <p class="comment-date">Posted on August 19, 2023</p>
                        </div>
                        </div>
                    <div class="view-more-comments">
                        <a href="#" style="text-decoration: underline; font-weight: 500;">Ver mais</a>
                    </div>
                </div>
                <div class="tab-pane" id="faqs">
                    <p>Aqui vão as perguntas e respostas frequentes sobre o produto.</p>
                </div>
            </div>
        </section>

        <section class="container related-products-section"> <h2 class="section-title">Destaques para você</h2>
            <div class="product-grid" id="related-products-grid">
                </div>
        </section>

    </div>

    <!-- Modal de Comentário -->
    <div id="comment-modal-overlay" class="modal-overlay" style="display: none;">
        <div class="modal-container" style="max-width: 600px; background: white; border-radius: 12px; padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="margin: 0; font-size: 1.5rem;">Deixar um comentário</h2>
                <button id="close-comment-modal" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            </div>
            <form id="comment-form">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Sua avaliação</label>
                    <div class="rating-input" style="display: flex; gap: 0.5rem;">
                        <span class="star-rating" data-value="1">⭐</span>
                        <span class="star-rating" data-value="2">⭐</span>
                        <span class="star-rating" data-value="3">⭐</span>
                        <span class="star-rating" data-value="4">⭐</span>
                        <span class="star-rating" data-value="5">⭐</span>
                    </div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label for="comment-name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nome</label>
                    <input type="text" id="comment-name" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label for="comment-text" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Comentário</label>
                    <textarea id="comment-text" required rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; resize: vertical;"></textarea>
                </div>
                <button type="submit" class="btn btn-dark" style="width: 100%;">Enviar Comentário</button>
            </form>
        </div>
    </div>

@include('partials.contact')
@endsection
