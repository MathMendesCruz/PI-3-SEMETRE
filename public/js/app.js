/**
 * Application Entry Point
 * Initializes all modules and features
 */

// Import modules
import { AuthModule } from './modules/auth/authentication.js';
import { FiltersModule } from './modules/products/filters.js';
import { SortingModule } from './modules/products/sorting.js';
import { BrandsBarModule } from './modules/ui/brands-carousel.js';
import { MenuModule } from './modules/ui/menu.js';
import { ContactFormModule } from './modules/ui/contact-form.js';
import { CartModule } from './modules/cart/cart-manager.js';
import { AddToCartModule } from './modules/cart/add-to-cart.js';
import { HistoryManager } from './modules/navigation/history-manager.js';

// Initialize application
document.addEventListener('DOMContentLoaded', () => {
    // Initialize navigation history (FIRST - to track page visit)
    HistoryManager.init();

    // Initialize authentication
    AuthModule.init();

    // Initialize product filters
    FiltersModule.init();

    // Initialize product sorting
    SortingModule.init();    // Initialize brands carousel
    BrandsBarModule.init();

    // Initialize navigation menus
    MenuModule.init();

    // Initialize contact form
    ContactFormModule.init();

    // Initialize add to cart button
    AddToCartModule.init();

    // Initialize cart (if on cart page)
    if (document.getElementById('cart-items')) {
        CartModule.init();
    }

    // Initialize alert animations
    initializeAlertAnimations();

    // Initialize global utilities
    initializeGlobalUtilities();
});

/**
 * Initialize alert animation styles
 */
function initializeAlertAnimations() {
    if (document.querySelector('style[data-alerts]')) return;

    const style = document.createElement('style');
    style.setAttribute('data-alerts', 'true');
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
}

/**
 * Initialize global utilities and features
 */
function initializeGlobalUtilities() {
    // Close top bar
    const closeTopBarBtn = document.querySelector('.top-bar .close-btn');
    if (closeTopBarBtn) {
        closeTopBarBtn.addEventListener('click', () => {
            closeTopBarBtn.parentElement.style.display = 'none';
        });
    }

    // Format currency helper
    window.formatCurrency = (value) => {
        const numberValue = Number(value);
        if (isNaN(numberValue)) return 'R$ -.--';
        return numberValue.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    };

    // Cart functionality
    initializeCart();
}

/**
 * Initialize shopping cart functionality
 */
function initializeCart() {
    const cartCountBadge = document.querySelector('.cart-item-count');

    window.getCartFromStorage = () => {
        const cartJSON = localStorage.getItem('joalheriaCart');
        return cartJSON ? JSON.parse(cartJSON) : [];
    };

    window.saveCartToStorage = (cart) => {
        localStorage.setItem('joalheriaCart', JSON.stringify(cart));
    };

    window.getTotalItemsInCart = () => {
        const cart = window.getCartFromStorage();
        return cart.reduce((total, item) => total + item.quantity, 0);
    };

    window.updateCartCounter = (totalItems) => {
        if (cartCountBadge) {
            cartCountBadge.textContent = totalItems;
            cartCountBadge.classList.toggle('visible', totalItems > 0);
        }
    };

    window.addItemToCart = (productId) => {
        let cart = window.getCartFromStorage();
        let existingItem = cart.find(item => item.id === productId);

        if (existingItem) {
            existingItem.quantity++;
        } else {
            cart.push({
                id: productId,
                name: `Produto ${productId}`,
                price: 99.99,
                img: 'img/placeholder.svg',
                quantity: 1
            });
        }

        window.saveCartToStorage(cart);
        const totalItems = window.getTotalItemsInCart();
        window.updateCartCounter(totalItems);
    };

    // Initialize cart counter on page load
    const totalItems = window.getTotalItemsInCart();
    window.updateCartCounter(totalItems);
}
