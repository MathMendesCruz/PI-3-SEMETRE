@extends('layouts.app')

@section('title', 'Finalizar Compra - Elegance Joias')

@section('content')
<div class="container" style="padding: 40px 20px; max-width: 1200px;">
    @if(!auth()->check())
        <div style="text-align: center; padding: 60px 20px;">
            <h1>Acesso Negado</h1>
            <p style="margin: 20px 0;">Para finalizar a compra, você precisa estar logado.</p>
            <a href="{{ route('login') }}" class="btn btn-dark">Fazer Login</a>
            <span style="margin: 0 10px;">ou</span>
            <a href="{{ route('cadastro') }}" class="btn btn-outline">Criar Conta</a>
        </div>
    @else
        <h1 style="margin-bottom: 10px;">Finalizar Compra</h1>
        <p style="color: #666; margin-bottom: 30px;">Pedido #{{ uniqid() }}</p>

        @php
            $cart = session('cart', []);
            $subtotal = 0;
            foreach($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $shipping = 15.00;
            $coupon = session('coupon');
            $discount = $coupon['discount'] ?? 0;
            $total = $subtotal + $shipping - $discount;
        @endphp

        @if(empty($cart))
            <div style="text-align: center; padding: 40px;">
                <h2>Seu carrinho está vazio</h2>
                <p style="margin: 20px 0;">Adicione produtos antes de finalizar a compra.</p>
                <a href="{{ route('index') }}" class="btn btn-dark">Continuar Comprando</a>
            </div>
        @else
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 30px;">
                <!-- Formulário de Entrega -->
                <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2 style="margin-bottom: 20px;">Informações de Entrega</h2>

                    <form id="checkout-form" method="POST" action="{{ route('orders.store') }}">
                        @csrf

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">CEP *</label>
                            <div style="display: flex; gap: 10px;">
                                <input type="text" id="postal-code" name="postal_code"
                                       maxlength="9" required placeholder="00000-000"
                                       style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                <button type="button" id="validate-cep-btn" class="btn btn-secondary"
                                        style="padding: 10px 20px;">Buscar</button>
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Endereço Completo *</label>
                            <textarea id="address" name="shipping_address" rows="3" required
                                      placeholder="Rua, número, complemento, bairro, cidade"
                                      style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
                        </div>

                        <h3 style="margin: 30px 0 15px;">Método de Pagamento</h3>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <label style="padding: 15px; border: 2px solid #eee; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 10px;">
                                <input type="radio" name="payment_method" value="credit_card" required>
                                <span>Cartão de Crédito</span>
                            </label>
                            <label style="padding: 15px; border: 2px solid #eee; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 10px;">
                                <input type="radio" name="payment_method" value="debit_card">
                                <span>Cartão de Débito</span>
                            </label>
                            <label style="padding: 15px; border: 2px solid #eee; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 10px;">
                                <input type="radio" name="payment_method" value="pix">
                                <span>PIX</span>
                            </label>
                            <label style="padding: 15px; border: 2px solid #eee; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 10px;">
                                <input type="radio" name="payment_method" value="boleto">
                                <span>Boleto</span>
                            </label>
                        </div>

                        <div style="margin-top: 30px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Observações (Opcional)</label>
                            <textarea id="notes" name="customer_notes" rows="2"
                                      placeholder="Adicione qualquer observação importante..."
                                      style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
                        </div>

                        <button type="submit" class="btn btn-dark"
                                style="width: 100%; padding: 15px; margin-top: 30px; font-size: 16px;">
                            Finalizar Compra
                        </button>
                    </form>
                </div>

                <!-- Resumo do Pedido -->
                <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); height: fit-content;">
                    <h2 style="margin-bottom: 20px;">Resumo do Pedido</h2>

                    <div style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
                        @foreach($cart as $item)
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                                <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                                <span>R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; justify-content: space-between;">
                            <span>Subtotal:</span>
                            <span>R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                        </div>

                        @if($coupon)
                            <div style="display: flex; justify-content: space-between; color: #28a745;">
                                <span>Desconto ({{ $coupon['code'] }}):</span>
                                <span>- R$ {{ number_format($discount, 2, ',', '.') }}</span>
                            </div>
                        @endif

                        <div style="display: flex; justify-content: space-between;">
                            <span>Frete:</span>
                            <span id="shipping-cost">R$ {{ number_format($shipping, 2, ',', '.') }}</span>
                        </div>

                        <div style="display: flex; justify-content: space-between; border-top: 2px solid #eee; padding-top: 10px; margin-top: 10px; font-size: 18px; font-weight: bold;">
                            <span>Total:</span>
                            <span id="total-amount">R$ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>
                    </div>

                    @if(!$coupon)
                        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Cupom de Desconto</label>
                            <div style="display: flex; gap: 10px;">
                                <input type="text" id="coupon-code" placeholder="Código do cupom"
                                       style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                <button type="button" id="apply-coupon-btn" class="btn btn-secondary"
                                        style="padding: 10px 15px;">Aplicar</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <style>
                .btn {
                    display: inline-block;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    text-align: center;
                    text-decoration: none;
                    transition: background 0.3s ease;
                }

                .btn-dark {
                    background: #333;
                    color: white;
                }

                .btn-dark:hover {
                    background: #555;
                }

                .btn-outline {
                    background: transparent;
                    color: #333;
                    border: 2px solid #333;
                }

                .btn-outline:hover {
                    background: #f0f0f0;
                }

                .btn-secondary {
                    background: #c9a55c;
                    color: white;
                }

                .btn-secondary:hover {
                    background: #b8944d;
                }

                @media (max-width: 768px) {
                    [style*="grid-template-columns"] {
                        grid-template-columns: 1fr !important;
                    }
                }
            </style>
        @endif
    @endif
</div>

<script>
document.getElementById('checkout-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData);

    try {
        const response = await fetch('{{ route('orders.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Pedido realizado com sucesso!', 'success');
            // Redireciona para página de sucesso com botão de feedback
            setTimeout(() => {
                window.location.href = result.redirect || '{{ route('order.success') }}';
            }, 1500);
        } else {
            showNotification('Erro: ' + result.message, 'error');
        }
    } catch (error) {
        console.error('Erro:', error);
        showNotification('Erro ao processar pedido', 'error');
    }
});
</script>
@endsection
