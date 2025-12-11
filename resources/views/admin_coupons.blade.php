@extends('layouts.admin')

@section('title', 'Painel ADM - Cupons de Desconto')

@section('breadcrumb', 'Cupons')

@section('content')
<div class="admin-card">
    <h2>Cupons de Desconto</h2>
    <p class="subtitle">Total de cupons: {{ $coupons->total() }}</p>

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
        <a href="{{ route('adm.coupons') }}" class="active">Cupons</a>
        <a href="{{ route('adm.coupons.create') }}" class="btn btn-dark" style="margin-left: auto;">+ Novo Cupom</a>
    </nav>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Compra Mínima</th>
                    <th>Uso</th>
                    <th>Validade</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                    <tr>
                        <td><strong>{{ $coupon->code }}</strong></td>
                        <td>
                            @if($coupon->type === 'percentage')
                                <span class="badge" style="background-color: #4CAF50; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.85em;">Percentual</span>
                            @else
                                <span class="badge" style="background-color: #2196F3; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.85em;">Fixo</span>
                            @endif
                        </td>
                        <td>
                            @if($coupon->type === 'percentage')
                                {{ $coupon->value }}%
                            @else
                                R$ {{ number_format($coupon->value, 2, ',', '.') }}
                            @endif
                        </td>
                        <td>
                            @if($coupon->min_purchase)
                                R$ {{ number_format($coupon->min_purchase, 2, ',', '.') }}
                            @else
                                <span style="color: #999;">-</span>
                            @endif
                        </td>
                        <td>
                            {{ $coupon->usage_count ?? 0 }}
                            @if($coupon->usage_limit)
                                / {{ $coupon->usage_limit }}
                            @endif
                        </td>
                        <td style="font-size: 0.85em;">
                            @if($coupon->valid_from)
                                {{ \Carbon\Carbon::parse($coupon->valid_from)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                            até
                            @if($coupon->valid_until)
                                {{ \Carbon\Carbon::parse($coupon->valid_until)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($coupon->active)
                                <span class="badge" style="background-color: #4CAF50; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.85em;">Ativo</span>
                            @else
                                <span class="badge" style="background-color: #999; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.85em;">Inativo</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('adm.coupons.edit', $coupon->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                                <form action="{{ route('adm.coupons.destroy', $coupon->id) }}" method="POST" class="inline-form">
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
                            <p>Nenhum cupom cadastrado. <a href="{{ route('adm.coupons.create') }}">Criar novo cupom</a></p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($coupons->hasPages())
        <div style="margin-top: 20px;">
            {{ $coupons->links('vendor.pagination.simple') }}
        </div>
    @endif
</div>
@endsection
