/**
 * Product Sorting Module
 * Handles product sorting functionality
 */

export const SortingModule = {
    init() {
        const sortSelect = document.getElementById('sort-select');
        const productListing = document.getElementById('product-listing');

        if (!sortSelect || !productListing) return;

        sortSelect.addEventListener('change', (e) => {
            this.sortProducts(e.target.value, productListing);
        });
    },

    sortProducts(sortOption, productListing) {
        const products = Array.from(productListing.querySelectorAll('.product-card'));

        products.sort((a, b) => {
            switch(sortOption) {
                case 'newest':
                    return (parseInt(b.getAttribute('data-productid')) || 0) - (parseInt(a.getAttribute('data-productid')) || 0);
                
                case 'price-asc':
                    const priceA = parseFloat(a.getAttribute('data-price')) || 0;
                    const priceB = parseFloat(b.getAttribute('data-price')) || 0;
                    return priceA - priceB;
                
                case 'price-desc':
                    const priceA2 = parseFloat(a.getAttribute('data-price')) || 0;
                    const priceB2 = parseFloat(b.getAttribute('data-price')) || 0;
                    return priceB2 - priceA2;
                
                case 'name-asc':
                    const nameA = a.querySelector('h3')?.textContent || '';
                    const nameB = b.querySelector('h3')?.textContent || '';
                    return nameA.localeCompare(nameB, 'pt-BR');
                
                case 'name-desc':
                    const nameA2 = a.querySelector('h3')?.textContent || '';
                    const nameB2 = b.querySelector('h3')?.textContent || '';
                    return nameB2.localeCompare(nameA2, 'pt-BR');
                
                case 'popular':
                default:
                    return 0;
            }
        });

        // Re-insere os produtos ordenados
        products.forEach(product => {
            productListing.appendChild(product);
        });
    }
};
