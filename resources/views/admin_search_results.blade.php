@extends('layouts.admin')

@section('title', 'Resultados da Pesquisa - Painel ADM')

@section('breadcrumb', 'Resultados da Pesquisa')

@section('content')
<div class="admin-card">
    <h2>Resultados para: "{{ $query }}"</h2>
    <p class="subtitle">{{ $products->total() + $users->total() }} resultado(s) encontrado(s)</p>

    @if($products->total() > 0)
        <section style="margin-bottom: 40px;">
            <h3 style="margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid var(--color-primary);">
                <i class="fas fa-boxes"></i> Produtos ({{ $products->total() }})
            </h3>
            
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <img src="{{ asset('img/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;"
                                             onerror="this.src='{{ asset('img/placeholder.svg') }}'">
                                        <span>{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td>{{ ucfirst($product->category) }}</td>
                                <td>{{ $product->brand ?? 'N/A' }}</td>
                                <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <a href="{{ route('adm-produto-editar', $product->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div style="margin-top: 20px;">
                    {{ $products->appends(['q' => $query])->links() }}
                </div>
            @endif
        </section>
    @endif

    @if($users->total() > 0)
        <section style="margin-bottom: 40px;">
            <h3 style="margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid var(--color-primary);">
                <i class="fas fa-users"></i> Usuários ({{ $users->total() }})
            </h3>
            
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>ID</th>
                            <th>Admin</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->id }}</td>
                                <td>
                                    @if($user->is_admin)
                                        <span style="color: var(--color-primary); font-weight: 600;">
                                            <i class="fas fa-shield-alt"></i> Sim
                                        </span>
                                    @else
                                        <span style="color: #999;">Não</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('adm-usuarios-editar', $user->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div style="margin-top: 20px;">
                    {{ $users->appends(['q' => $query])->links() }}
                </div>
            @endif
        </section>
    @endif

    @if($products->total() === 0 && $users->total() === 0)
        <div style="text-align: center; padding: 60px 20px;">
            <i class="fas fa-search" style="font-size: 4rem; color: #ddd; margin-bottom: 20px;"></i>
            <h3 style="color: #666; margin-bottom: 10px;">Nenhum resultado encontrado</h3>
            <p style="color: #999;">Tente usar outras palavras-chave ou verifique a ortografia.</p>
            <a href="{{ route('adm-dashboard') }}" class="btn btn-dark" style="margin-top: 20px;">
                Voltar ao Dashboard
            </a>
        </div>
    @endif
</div>
@endsection
