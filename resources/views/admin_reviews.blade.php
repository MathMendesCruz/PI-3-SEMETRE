@extends('layouts.admin')

@section('title', 'Painel ADM - Avaliações de Produtos')

@section('breadcrumb', 'Avaliações')

@section('content')
<div class="admin-card">
    <h2>Avaliações de Produtos</h2>
    <p class="subtitle">Total de avaliações: {{ $reviews->total() }}</p>

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
        <a href="{{ route('adm.coupons') }}">Cupons</a>
        <a href="{{ route('adm.reviews') }}" class="active">Avaliações</a>
    </nav>

    <div class="admin-action-bar">
        <button class="btn btn-secondary dropdown-toggle" onclick="filterReviews('all')">Todos</button>
        <button class="btn btn-secondary" onclick="filterReviews('pending')">Pendentes</button>
        <button class="btn btn-secondary" onclick="filterReviews('approved')">Aprovados</button>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Usuário</th>
                    <th>Avaliação</th>
                    <th>Comentário</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr data-status="{{ $review->approved ? 'approved' : 'pending' }}">
                        <td>
                            <a href="{{ route('produto', $review->product_id) }}" target="_blank" style="color: #333; text-decoration: none;">
                                {{ Str::limit($review->product->name ?? 'N/A', 30) }}
                            </a>
                        </td>
                        <td>{{ $review->user->name ?? 'Usuário deletado' }}</td>
                        <td>
                            <div style="display: flex; gap: 2px;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20" fill="#fbbf24">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20" fill="#d1d5db">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td style="max-width: 300px;">
                            <div style="max-height: 60px; overflow: hidden; text-overflow: ellipsis;">
                                {{ Str::limit($review->comment, 100) }}
                            </div>
                        </td>
                        <td style="font-size: 0.85em;">{{ $review->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($review->approved)
                                <span class="badge" style="background-color: #4CAF50; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.85em;">Aprovado</span>
                            @else
                                <span class="badge" style="background-color: #ff9800; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.85em;">Pendente</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                @if(!$review->approved)
                                    <form action="{{ route('adm.reviews.approve', $review->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm" style="background-color: #4CAF50; color: white; padding: 4px 8px; border: none; border-radius: 4px; cursor: pointer;">
                                            <i class="fas fa-check"></i> Aprovar
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('adm.reviews.reject', $review->id) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja deletar esta avaliação?')">
                                        <i class="fas fa-times"></i> Rejeitar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="no-products">
                            <p>Nenhuma avaliação encontrada.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
        <div style="margin-top: 20px;">
            {{ $reviews->links('vendor.pagination.simple') }}
        </div>
    @endif
</div>

<script>
function filterReviews(status) {
    const rows = document.querySelectorAll('tbody tr[data-status]');
    rows.forEach(row => {
        if (status === 'all') {
            row.style.display = '';
        } else {
            row.style.display = row.dataset.status === status ? '' : 'none';
        }
    });
}
</script>

@endsection
