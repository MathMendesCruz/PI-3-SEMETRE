@extends('layouts.admin')

@section('title', 'Painel ADM - Pedidos Realizados')

@section('breadcrumb', 'Pedidos')

@section('content')
<div class="admin-card">
    <h2>Pedidos Realizados</h2>
    <p class="subtitle">Gestão de compras realizadas pelos clientes</p>

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
        <a href="{{ route('adm.usuarios') }}">Usuários</a>
        <a href="{{ route('adm.orders') }}" class="active">Pedidos</a>
        <a href="{{ route('adm.coupons') }}">Cupons</a>
        <a href="{{ route('adm.reviews') }}">Avaliações</a>
    </nav>

    <div class="admin-action-bar">
        <input type="text" id="search-filter" placeholder="Filtrar por número do pedido ou cliente..." class="filter-input" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; margin-right: 10px; width: 300px;">
        <button class="btn btn-secondary" onclick="filterByStatus('all')">Todos</button>
        <button class="btn btn-secondary" onclick="filterByStatus('pending')">Pendentes</button>
        <button class="btn btn-secondary" onclick="filterByStatus('processing')">Em Processamento</button>
        <button class="btn btn-secondary" onclick="filterByStatus('completed')">Entregues</button>
        <button class="btn btn-secondary" onclick="filterByStatus('cancelled')">Cancelados</button>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nº Pedido</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Subtotal</th>
                    <th>Desconto</th>
                    <th>Frete</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr data-status="{{ $order->status }}" data-order="{{ $order->order_number }}" data-client="{{ strtolower($order->user->name ?? '') }}">
                        <td><strong>#{{ $order->order_number }}</strong></td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td style="font-size: 0.85em;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>R$ {{ number_format($order->subtotal, 2, ',', '.') }}</td>
                        <td>
                            @if($order->discount_amount > 0)
                                <span style="color: #4CAF50;">-R$ {{ number_format($order->discount_amount, 2, ',', '.') }}</span>
                            @else
                                <span style="color: #999;">-</span>
                            @endif
                        </td>
                        <td>R$ {{ number_format($order->shipping, 2, ',', '.') }}</td>
                        <td><strong>R$ {{ number_format($order->total, 2, ',', '.') }}</strong></td>
                        <td>
                            @php
                                $statusLabels = [
                                    'pending' => ['text' => 'Pendente', 'color' => '#ff9800'],
                                    'processing' => ['text' => 'Em Processamento', 'color' => '#2196F3'],
                                    'completed' => ['text' => 'Entregue', 'color' => '#4CAF50'],
                                    'cancelled' => ['text' => 'Cancelado', 'color' => '#f44336'],
                                ];
                                $statusInfo = $statusLabels[$order->status] ?? ['text' => ucfirst($order->status), 'color' => '#666'];
                            @endphp
                            <span class="badge" style="background-color: {{ $statusInfo['color'] }}; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.85em;">
                                {{ $statusInfo['text'] }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('adm.orders.show', $order->id) }}" class="btn btn-sm btn-secondary">Detalhes</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="no-products">
                            <p>Nenhum pedido encontrado.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div style="margin-top: 20px;">
            {{ $orders->links('vendor.pagination.simple') }}
        </div>
    @endif
</div>

<script>
function filterByStatus(status) {
    const rows = document.querySelectorAll('tbody tr[data-status]');
    rows.forEach(row => {
        if (status === 'all') {
            row.style.display = '';
        } else {
            row.style.display = row.dataset.status === status ? '' : 'none';
        }
    });
}

// Filtro por texto (número do pedido e cliente)
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-filter');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr[data-order]');

            rows.forEach(row => {
                const orderNumber = row.dataset.order.toLowerCase();
                const client = row.dataset.client;

                if (orderNumber.includes(searchTerm) || client.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>

@endsection
