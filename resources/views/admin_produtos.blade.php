@extends('layouts.admin')

@section('title', 'Painel ADM - Produtos em Estoque')

@section('breadcrumb', 'Produtos em Estoque')

@section('content')
<div class="admin-card">
            <h2>Em estoque</h2>
            <p class="subtitle">Produtos em Estoque (Total: {{ $products->total() }})</p>

            @if($message = session('success'))
                <div style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                    {{ $message }}
                </div>
            @endif

            @if($message = session('error'))
                <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                    {{ $message }}
                </div>
            @endif

            <nav class="admin-tabs">
                <a href="{{ route('adm.produto') }}" class="active">Em estoque</a>
                <a href="{{ route('adm.usuarios') }}">Usuários</a>
                <a href="{{ route('adm.orders') }}">Pedidos</a>
                <a href="{{ route('adm.coupons') }}">Cupons</a>
                <a href="{{ route('adm.reviews') }}">Avaliações</a>
                <a href="{{ route('adm.produto.criar') }}" class="btn btn-dark" style="margin-left: auto;">+ Novo Produto</a>
            </nav>

            <div class="admin-action-bar">
                <button class="icon-button"><i class="far fa-calendar-alt"></i></button>
                <button class="btn btn-secondary dropdown-toggle">Filtros <i class="fas fa-chevron-down"></i></button>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>ID</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <span class="badge badge-{{ $product->category }}">
                                        {{ ucfirst($product->category) }}
                                    </span>
                                </td>
                                <td>{{ $product->brand ?? '-' }}</td>
                                <td>{{ $product->id }}</td>
                                <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                @php($threshold = $product->min_stock ?? 5)
                                <td>
                                    <span class="stock-badge {{ $product->stock <= $threshold ? 'stock-low' : 'stock-ok' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>{{ $product->created_at->format('d.m.Y') }} <span class="time">{{ $product->created_at->format('H:i') }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('adm.produto.editar', $product->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                                        <form action="{{ route('adm.produto.delete', $product->id) }}" method="POST" class="inline-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Deletar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="no-products">
                                    <p>Nenhum produto encontrado. <a href="{{ route('adm.produto.criar') }}">Criar novo produto</a></p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                {{ $products->links('vendor.pagination.simple') }}
            @endif
        </div>
@endsection
