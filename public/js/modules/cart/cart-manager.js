export const CartModule = {
    cart: [],
    
    init() {
        this.loadCart();
        this.renderCart();
        this.attachEventListeners();
        this.updateSummary();
    },
    
    loadCart() {
        const stored = localStorage.getItem('cart');
        this.cart = stored ? JSON.parse(stored) : [];
    },
    
    saveCart() {
        localStorage.setItem('cart', JSON.stringify(this.cart));
    },
    
    addProduct(product) {
        const existing = this.cart.find(item => item.id === product.id);
        
        if (existing) {
            existing.quantity += product.quantity || 1;
        } else {
            this.cart.push({
                id: product.id,
                name: product.name,
                price: parseFloat(product.price),
                image: product.image,
                quantity: product.quantity || 1
            });
        }
        
        this.saveCart();
        this.renderCart();
        this.updateSummary();
    },
    
    removeProduct(productId) {
        this.cart = this.cart.filter(item => item.id !== productId);
        this.saveCart();
        this.renderCart();
        this.updateSummary();
    },
    
    updateQuantity(productId, quantity) {
        const item = this.cart.find(item => item.id === productId);
        if (item) {
            item.quantity = Math.max(1, quantity);
            this.saveCart();
            this.renderCart();
            this.updateSummary();
        }
    },
    
    renderCart() {
        const container = document.getElementById('cart-items');
        
        if (this.cart.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 60px 20px; grid-column: 1;">
                    <h3 style="color: #999; margin-bottom: 20px;">Seu carrinho está vazio</h3>
                    <p style="color: #bbb; margin-bottom: 30px;">Adicione produtos para começar suas compras</p>
                    <a href="/" class="btn btn-dark">Voltar para Produtos</a>
                </div>
            `;
            return;
        }
        
        const html = this.cart.map(item => `
            <article class="cart-item" data-product-id="${item.id}" data-price="${item.price}">
                <div class="item-details">
                    <img src="${item.image}" alt="${item.name}">
                    <div>
                        <h2>${item.name}</h2>
                        <p class="price">R$${item.price.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</p>
                    </div>
                </div>
                <div class="item-controls">
                    <div class="quantity-selector">
                        <button class="decrease-qty" data-product-id="${item.id}">-</button>
                        <span class="quantity-value">${item.quantity}</span>
                        <button class="increase-qty" data-product-id="${item.id}">+</button>
                    </div>
                    <button class="delete-item-btn" data-product-id="${item.id}" title="Remover">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>
                    </button>
                </div>
            </article>
        `).join('');
        
        container.innerHTML = html;
    },
    
    updateSummary() {
        const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        
        document.getElementById('subtotal').textContent = 
            'R$' + subtotal.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
        document.getElementById('total').textContent = 
            'R$' + subtotal.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
    },
    
    attachEventListeners() {
        document.addEventListener('click', (e) => {
            const productId = e.target.dataset.productId;
            
            if (e.target.classList.contains('increase-qty')) {
                const item = this.cart.find(i => i.id == productId);
                if (item) this.updateQuantity(item.id, item.quantity + 1);
            }
            
            if (e.target.classList.contains('decrease-qty')) {
                const item = this.cart.find(i => i.id == productId);
                if (item) this.updateQuantity(item.id, item.quantity - 1);
            }
            
            if (e.target.classList.contains('delete-item-btn') || 
                e.target.closest('.delete-item-btn')) {
                this.removeProduct(parseInt(productId));
            }
        });
    }
};
