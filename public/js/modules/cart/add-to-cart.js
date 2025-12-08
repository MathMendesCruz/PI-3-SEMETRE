export const AddToCartModule = {
    init() {
        this.attachEventListeners();
    },
    
    attachEventListeners() {
        const addBtn = document.querySelector('.add-to-cart-btn');
        if (!addBtn) return;
        
        addBtn.addEventListener('click', (e) => {
            e.preventDefault();
            this.addToCart();
        });
    },
    
    addToCart() {
        const productElement = document.querySelector('[data-product-id]');
        if (!productElement) return;
        
        const product = {
            id: parseInt(productElement.dataset.productId),
            name: productElement.dataset.productName,
            price: productElement.dataset.productPrice,
            image: productElement.dataset.productImage,
            quantity: 1
        };
        
        // Import CartModule dynamically to avoid circular dependencies
        import('./cart/cart-manager.js').then(({ CartModule }) => {
            CartModule.loadCart();
            CartModule.addProduct(product);
            
            // Show success message
            this.showNotification(`${product.name} adicionado ao carrinho!`);
        });
    },
    
    showNotification(message) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'cart-notification';
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border-radius: 4px;
            z-index: 9999;
            animation: slideIn 0.3s ease-out;
        `;
        
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
};
