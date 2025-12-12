@extends('layouts.admin')

@section('title', 'Painel ADM - Usuários Cadastrados')

@section('breadcrumb', 'Usuários')

@section('content')

 <div class="admin-card">
            <h2>Clientes Cadastrados</h2>
            <p class="subtitle">Total de clientes: {{ $users->total() }} | Administradores: {{ $admins->total() }}</p>

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
                <a href="{{ route('adm.produto') }}">Em estoque</a>
                <a href="{{ route('adm.usuarios') }}" class="active">Usuários</a>
                <a href="{{ route('adm.orders') }}">Pedidos</a>
                <a href="{{ route('adm.coupons') }}">Cupons</a>
                <a href="{{ route('adm.reviews') }}">Avaliações</a>
                <a href="{{ route('adm.produto.criar') }}">Cadastrar Produtos</a>
            </nav>
            <div class="admin-action-bar">
                <a href="{{ route('adm.usuarios.criar') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-user-plus"></i> Novo Administrador
                </a>
                <button class="icon-button"><i class="far fa-calendar-alt"></i></button> <button class="btn btn-secondary dropdown-toggle">Filtros <i class="fas fa-chevron-down"></i></button>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>ID</th>
                            <th>Data de Registro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('adm.usuarios.editar', $user->id) }}" class="btn btn-sm btn-secondary" style="padding: 4px 8px; font-size: 0.85em; background-color: #666; color: white; border: none; border-radius: 4px; text-decoration: none; display: inline-block;">Editar</a>
                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('adm.usuarios.delete', $user->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" style="padding: 4px 8px; font-size: 0.85em; background-color: #d32f2f; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="return confirm('Tem certeza que deseja deletar este cliente?')">Deletar</button>
                                            </form>
                                        @else
                                            <span style="color: #999; font-size: 0.9em; padding: 4px 8px;">Você</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 30px;">
                                    <p>Nenhum cliente encontrado.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                {{ $users->links('vendor.pagination.simple') }}
            @endif
        </div>

        <!-- Seção de Administradores -->
        <div class="admin-card" style="margin-top: 20px;">
            <h2>Administradores</h2>
            <p class="subtitle">Total de administradores: {{ $admins->total() }}</p>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>ID</th>
                            <th>Data de Registro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                            <tr>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->id }}</td>
                                <td>{{ $admin->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('adm.usuarios.editar', $admin->id) }}" class="btn btn-sm btn-secondary" style="padding: 4px 8px; font-size: 0.85em; background-color: #666; color: white; border: none; border-radius: 4px; text-decoration: none; display: inline-block;">Editar</a>
                                        @if($admin->id !== Auth::id())
                                            <form action="{{ route('adm.usuarios.delete', $admin->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" style="padding: 4px 8px; font-size: 0.85em; background-color: #d32f2f; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="return confirm('Tem certeza que deseja deletar este administrador?')">Deletar</button>
                                            </form>
                                        @else
                                            <span style="color: #999; font-size: 0.9em; padding: 4px 8px;">Você</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 30px;">
                                    <p>Nenhum administrador encontrado.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($admins->hasPages())
                {{ $admins->links('vendor.pagination.simple') }}
            @endif
        </div>
@endsection
