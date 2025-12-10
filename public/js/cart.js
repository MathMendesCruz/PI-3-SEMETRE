/**
 * Sistema de Carrinho - Elegance Joias
 * Gerencia adição, remoção e atualização de produtos no carrinho
 */

// Configuração do CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

/**
 * Adiciona produto ao carrinho
 */
async function addToCart(productId, quantity = 1, productData = null) {
    try {
        const response = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        });

        const data = await response.json();

        if (data.success) {
            // Atualizar contador do carrinho
            updateCartCount(data.cart_count);

            // Mostrar mensagem de sucesso
            showNotification('Produto adicionado ao carrinho!', 'success');

            return true;
        } else {
            showNotification(data.message || 'Erro ao adicionar produto', 'error');
            return false;
        }
    } catch (error) {
        console.error('Erro:', error);
        showNotification('Erro ao adicionar produto ao carrinho', 'error');
        return false;
    }
}

/**
 * Atualiza quantidade de um produto no carrinho
 */
async function updateCartItem(productId, quantity) {
    try {
        const response = await fetch(`/cart/update/${productId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity })
        });

        const data = await response.json();

        if (data.success) {
            showNotification('Carrinho atualizado!', 'success');
            // Recarregar página do carrinho
            location.reload();
        } else {
            showNotification(data.message || 'Erro ao atualizar', 'error');
        }
    } catch (error) {
        console.error('Erro:', error);
        showNotification('Erro ao atualizar carrinho', 'error');
    }
}

/**
 * Remove produto do carrinho
 */
async function removeFromCart(productId) {
    if (!confirm('Deseja remover este produto do carrinho?')) {
        return;
    }

    try {
        const response = await fetch(`/cart/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            showNotification('Produto removido!', 'success');
            location.reload();
        } else {
            showNotification(data.message || 'Erro ao remover', 'error');
        }
    } catch (error) {
        console.error('Erro:', error);
        showNotification('Erro ao remover produto', 'error');
    }
}

/**
 * Aplica cupom de desconto
 */
async function applyCoupon() {
    const couponInput = document.getElementById('coupon-code');
    const code = couponInput?.value.trim();

    if (!code) {
        showNotification('Digite um código de cupom', 'warning');
        return;
    }

    try {
        const response = await fetch('/cart/apply-coupon', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ code })
        });

        const data = await response.json();

        if (data.success) {
            showNotification('Cupom aplicado com sucesso!', 'success');
            location.reload();
        } else {
            showNotification(data.message || 'Cupom inválido', 'error');
        }
    } catch (error) {
        console.error('Erro:', error);
        showNotification('Erro ao aplicar cupom', 'error');
    }
}

/**
 * Valida CEP e calcula frete
 */
async function validateCep() {
    const cepInput = document.getElementById('postal-code');
    const cep = cepInput?.value.replace(/\D/g, '');

    if (!cep || cep.length !== 8) {
        showNotification('Digite um CEP válido', 'warning');
        return;
    }

    try {
        const response = await fetch('/cart/validate-cep', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ cep })
        });

        const data = await response.json();

        if (data.success) {
            // Preencher campos de endereço
            if (data.address) {
                document.getElementById('address')?.value =
                    `${data.address.logradouro}, ${data.address.bairro}, ${data.address.localidade} - ${data.address.uf}`;
            }

            // Mostrar valor do frete
            if (data.shipping) {
                const shippingElement = document.getElementById('shipping-cost');
                if (shippingElement) {
                    shippingElement.textContent = `R$ ${data.shipping.toFixed(2).replace('.', ',')}`;
                }
            }

            showNotification('CEP validado!', 'success');
        } else {
            showNotification(data.message || 'CEP não encontrado', 'error');
        }
    } catch (error) {
        console.error('Erro:', error);
        showNotification('Erro ao validar CEP', 'error');
    }
}

/**
 * Atualiza contador do carrinho no header
 */
function updateCartCount(count) {
    const cartCounters = document.querySelectorAll('.cart-count, #cart-count');
    cartCounters.forEach(counter => {
        counter.textContent = count || 0;
        if (count > 0) {
            counter.style.display = 'inline-block';
        }
    });
}

/**
 * Mostra notificação ao usuário
 */
function showNotification(message, type = 'info') {
    // Criar elemento de notificação
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;

    // Estilos inline
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 5px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        animation: slideIn 0.3s ease-out;
        max-width: 300px;
    `;

    // Cores por tipo
    const colors = {
        success: '#28a745',
        error: '#dc3545',
        warning: '#ffc107',
        info: '#17a2b8'
    };
    notification.style.backgroundColor = colors[type] || colors.info;

    // Adicionar ao body
    document.body.appendChild(notification);

    // Remover após 3 segundos
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Event Listeners quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {

    // Botões "Adicionar ao Carrinho"
    document.querySelectorAll('.add-to-cart-btn, .btn-add-cart').forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();

            const productId = this.dataset.productId || this.getAttribute('data-product-id');
            const quantityElement = this.closest('.product-info, .product-card')?.querySelector('.quantity-value');
            const quantity = quantityElement ? parseInt(quantityElement.textContent) : 1;

            if (!productId) {
                showNotification('Erro: ID do produto não encontrado', 'error');
                return;
            }

            await addToCart(productId, quantity);
        });
    });

    // Seletores de quantidade (+ e -)
    document.querySelectorAll('.qty-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const valueElement = this.parentElement.querySelector('.quantity-value');
            if (valueElement) {
                let currentValue = parseInt(valueElement.textContent) || 1;
                valueElement.textContent = currentValue + 1;
            }
        });
    });

    document.querySelectorAll('.qty-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const valueElement = this.parentElement.querySelector('.quantity-value');
            if (valueElement) {
                let currentValue = parseInt(valueElement.textContent) || 1;
                if (currentValue > 1) {
                    valueElement.textContent = currentValue - 1;
                }
            }
        });
    });

    // Botão aplicar cupom
    const applyCouponBtn = document.getElementById('apply-coupon-btn');
    if (applyCouponBtn) {
        applyCouponBtn.addEventListener('click', applyCoupon);
    }

    // Botão validar CEP
    const validateCepBtn = document.getElementById('validate-cep-btn');
    if (validateCepBtn) {
        validateCepBtn.addEventListener('click', validateCep);
    }

    // Máscara de CEP
    const cepInput = document.getElementById('postal-code');
    if (cepInput) {
        cepInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.slice(0, 5) + '-' + value.slice(5, 8);
            }
            e.target.value = value;
        });
    }
});

// Adicionar estilos de animação
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
