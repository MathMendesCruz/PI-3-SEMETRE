/**
 * Product Filters Module
 * Handles filtering by category, price, color, and brand
 */

export const FiltersModule = {
    init() {
        const productListing = document.getElementById('product-listing');
        if (!productListing) return;

        this.productListing = productListing;
        this.filterState = {
            category: 'todos',
            color: null,
            brand: null,
            maxPrice: 10000,
            currentPage: 1,
            productsPerPage: 6
        };
        this.allProducts = [];

        this.setupEventListeners();
        this.captureAllProducts();
        this.applyFilters();
    },

    captureAllProducts() {
        const products = document.querySelectorAll('.product-card');
        this.allProducts = Array.from(products).map(el => ({
            element: el,
            price: parseFloat(el.getAttribute('data-price') || 0),
            color: el.getAttribute('data-color') || 'neutro',
            brand: el.getAttribute('data-brand') || null,
            type: el.getAttribute('data-type') || 'outros'
        }));
    },

    setupEventListeners() {
        const priceSlider = document.getElementById('price-slider-input');
        const priceValue = document.getElementById('price-slider-value');
        const categoryFilters = document.getElementById('category-filters');
        const colorFilters = document.getElementById('color-filters');
        const brandFilters = document.getElementById('brand-filters');
        const applyFiltersBtn = document.getElementById('apply-filters');

        if (priceSlider) {
            priceSlider.addEventListener('input', (e) => {
                this.filterState.maxPrice = parseInt(e.target.value);
                priceValue.textContent = `R$${this.filterState.maxPrice.toLocaleString('pt-BR')}`;
                this.filterState.currentPage = 1;
            });
        }

        if (categoryFilters) {
            categoryFilters.querySelectorAll('.filter-item').forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    categoryFilters.querySelectorAll('.filter-item').forEach(i => i.style.opacity = '0.6');
                    item.style.opacity = '1';
                    this.filterState.category = item.getAttribute('data-category');
                    this.filterState.currentPage = 1;
                    this.applyFilters();
                });
            });
            categoryFilters.querySelector('.filter-item').style.opacity = '1';
        }

        if (colorFilters) {
            colorFilters.querySelectorAll('.color-swatch').forEach(swatch => {
                swatch.addEventListener('click', (e) => {
                    e.preventDefault();
                    const chosen = swatch.getAttribute('data-color');
                    if (this.filterState.color === chosen) {
                        this.filterState.color = null;
                        colorFilters.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('selected'));
                    } else {
                        colorFilters.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('selected'));
                        swatch.classList.add('selected');
                        this.filterState.color = chosen;
                    }
                    this.filterState.currentPage = 1;
                    this.applyFilters();
                });
            });
        }

        if (brandFilters) {
            brandFilters.querySelectorAll('.filter-item').forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    const chosen = item.getAttribute('data-brand');
                    
                    // Se clicar em "Todas" ou no item já selecionado, limpa o filtro
                    if (chosen === 'todos' || this.filterState.brand === chosen) {
                        this.filterState.brand = null;
                        brandFilters.querySelectorAll('.filter-item').forEach(i => i.classList.remove('active'));
                        // Marca "Todas" como ativo quando limpar
                        if (chosen === 'todos') {
                            item.classList.add('active');
                        }
                    } else {
                        // Seleciona uma marca específica
                        brandFilters.querySelectorAll('.filter-item').forEach(i => i.classList.remove('active'));
                        item.classList.add('active');
                        this.filterState.brand = chosen;
                    }
                    this.filterState.currentPage = 1;
                    this.applyFilters();
                });
            });
        }

        if (applyFiltersBtn) {
            applyFiltersBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.applyFilters();
            });
        }
    },

    applyFilters() {
        this.captureAllProducts();
        
        const filtered = this.allProducts.filter(p => {
            let show = true;

            // Filtro de preço
            if (p.price > this.filterState.maxPrice) {
                show = false;
            }
            
            // Filtro de cor (só aplica se uma cor for selecionada)
            if (this.filterState.color && p.color && p.color !== this.filterState.color) {
                show = false;
            }
            
            // Filtro de marca (só aplica se uma marca for selecionada)
            if (this.filterState.brand && p.brand && p.brand !== this.filterState.brand) {
                show = false;
            }
            
            // Filtro de categoria
            if (this.filterState.category !== 'todos' && p.type !== this.filterState.category) {
                show = false;
            }

            return show;
        });

        this.renderProducts(filtered);
        this.renderPagination(filtered);
    },

    renderProducts(filtered) {
        this.productListing.innerHTML = '';

        if (filtered.length === 0) {
            const emptyMsg = document.createElement('p');
            emptyMsg.setAttribute('data-empty-message', 'true');
            emptyMsg.style.cssText = 'grid-column: 1 / -1; text-align: center; padding: 40px; color: #999; font-size: 16px;';
            emptyMsg.textContent = 'Nenhum produto encontrado com os filtros selecionados.';
            this.productListing.appendChild(emptyMsg);
            
            const counter = document.getElementById('filter-counter');
            if (counter) {
                counter.textContent = 'Nenhum produto encontrado';
            }
            return;
        }

        const startIdx = (this.filterState.currentPage - 1) * this.filterState.productsPerPage;
        const endIdx = startIdx + this.filterState.productsPerPage;
        const paginatedProducts = filtered.slice(startIdx, endIdx);

        paginatedProducts.forEach(p => {
            this.productListing.appendChild(p.element);
        });

        const totalCount = filtered.length;
        const startCount = startIdx + 1;
        const endCount = Math.min(endIdx, totalCount);
        
        const counter = document.getElementById('filter-counter');
        if (counter) {
            counter.textContent = `Exibindo ${startCount}-${endCount} de ${totalCount} Produto(s)`;
        }
    },

    renderPagination(filtered) {
        const pagination = document.querySelector('.pagination');
        if (!pagination) return;

        const totalPages = Math.ceil(filtered.length / this.filterState.productsPerPage);
        const paginationLinks = pagination.querySelectorAll('.page-link');

        paginationLinks.forEach(link => {
            if (link.textContent === '← Voltar') {
                link.style.display = this.filterState.currentPage > 1 ? '' : 'none';
                link.onclick = (e) => {
                    e.preventDefault();
                    if (this.filterState.currentPage > 1) {
                        this.filterState.currentPage--;
                        this.applyFilters();
                    }
                };
            } else if (link.textContent === 'Próximo →') {
                link.style.display = this.filterState.currentPage < totalPages ? '' : 'none';
                link.onclick = (e) => {
                    e.preventDefault();
                    if (this.filterState.currentPage < totalPages) {
                        this.filterState.currentPage++;
                        this.applyFilters();
                    }
                };
            } else if (!isNaN(parseInt(link.textContent))) {
                const pageNum = parseInt(link.textContent);
                link.style.display = pageNum <= totalPages ? '' : 'none';
                link.classList.toggle('active', pageNum === this.filterState.currentPage);
                link.onclick = (e) => {
                    e.preventDefault();
                    this.filterState.currentPage = pageNum;
                    this.applyFilters();
                };
            }
        });
    }
};
