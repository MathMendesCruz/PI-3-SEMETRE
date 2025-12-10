/**
 * Sistema de Filtros Completo e Funcional
 * Suporta: categoria, preço, cor e paginação
 */

document.addEventListener('DOMContentLoaded', () => {
    const productListing = document.getElementById('product-listing');
    const priceSlider = document.getElementById('price-slider-input');
    const priceValue = document.getElementById('price-slider-value');
    const applyFiltersBtn = document.getElementById('apply-filters');
    const categoryFilters = document.getElementById('category-filters');
    const colorFilters = document.getElementById('color-filters');
    const brandFilters = document.getElementById('brand-filters');
    const pagination = document.querySelector('.pagination');

    if (!productListing) return;

    // Estado dos filtros
    const filterState = {
        category: 'todos',
        color: null,
        brand: null,
        maxPrice: 10000,
        currentPage: 1,
        productsPerPage: 6
    };

    let allProducts = [];
    let originalHTML = productListing.innerHTML;

    // Capturar todos os produtos inicialmente
    function captureAllProducts() {
        const products = document.querySelectorAll('.product-card');
        allProducts = Array.from(products).map(el => ({
            element: el,
            price: parseFloat(el.getAttribute('data-price') || 0),
            color: el.getAttribute('data-color') || 'neutro',
            type: el.getAttribute('data-type') || 'outros',
            brand: el.getAttribute('data-brand') || null,
        }));
    }

    // ===== PREÇO =====
    if (priceSlider) {
        priceSlider.addEventListener('input', (e) => {
            filterState.maxPrice = parseInt(e.target.value);
            priceValue.textContent = `R$${filterState.maxPrice.toLocaleString('pt-BR')}`;
            filterState.currentPage = 1;
        });
    }

    // ===== MARCA =====
    if (brandFilters) {
        const brandItems = brandFilters.querySelectorAll('.filter-item');
        brandItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                brandItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');

                const chosen = item.getAttribute('data-brand');
                filterState.brand = chosen === 'todos' ? null : chosen;
                filterState.currentPage = 1;
                applyFilters();
            });
        });
        // marca padrão: todas
        brandItems[0]?.classList.add('active');
    }

    // ===== CATEGORIA =====
    if (categoryFilters) {
        const categoryItems = categoryFilters.querySelectorAll('.filter-item');
        categoryItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                categoryItems.forEach(i => i.style.opacity = '0.6');
                item.style.opacity = '1';
                filterState.category = item.getAttribute('data-category');
                filterState.currentPage = 1;
                applyFilters();
            });
        });
        categoryItems[0].style.opacity = '1';
    }

    // ===== COR =====
    if (colorFilters) {
        const colorSwatches = colorFilters.querySelectorAll('.color-swatch, button[data-color]');
        colorSwatches.forEach(swatch => {
            swatch.addEventListener('click', (e) => {
                e.preventDefault();
                const chosen = swatch.getAttribute('data-color');
                if (filterState.color === chosen) {
                    filterState.color = null;
                    colorSwatches.forEach(s => {
                        s.classList.remove('selected');
                        s.style.border = '';
                        s.style.boxShadow = '';
                    });
                } else {
                    colorSwatches.forEach(s => {
                        s.classList.remove('selected');
                        s.style.border = '';
                        s.style.boxShadow = '';
                    });
                    swatch.classList.add('selected');
                    swatch.style.border = '3px solid #c9a55c';
                    swatch.style.boxShadow = '0 0 8px rgba(201, 165, 92, 0.5)';
                    filterState.color = chosen;
                }
                filterState.currentPage = 1;
                applyFilters();
            });
        });
    }

    // ===== APLICAR FILTROS =====
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', (e) => {
            e.preventDefault();
            applyFilters();
        });
    }

    function applyFilters() {
        captureAllProducts();

        // Filtrar produtos baseado no estado
        const filtered = allProducts.filter(p => {
            let show = true;

            // Filtro de preço
            if (p.price > filterState.maxPrice) show = false;

            // Filtro de cor
            if (filterState.color && p.color !== filterState.color) show = false;

            // Filtro de marca
            if (filterState.brand && p.brand !== filterState.brand) show = false;

            // Filtro de categoria
            if (filterState.category !== 'todos' && p.type !== filterState.category) show = false;

            return show;
        });

        renderProducts(filtered);
        renderPagination(filtered);
    }

    function renderProducts(filtered) {
        // Limpar container
        productListing.innerHTML = '';

        if (filtered.length === 0) {
            const emptyMsg = document.createElement('p');
            emptyMsg.setAttribute('data-empty-message', 'true');
            emptyMsg.style.cssText = 'grid-column: 1 / -1; text-align: center; padding: 40px; color: #999; font-size: 16px;';
            emptyMsg.textContent = 'Nenhum produto encontrado com os filtros selecionados.';
            productListing.appendChild(emptyMsg);

            // Atualizar contador
            const counter = document.getElementById('filter-counter');
            if (counter) {
                counter.textContent = 'Nenhum produto encontrado';
            }
            return;
        }

        // Calcular paginação
        const startIdx = (filterState.currentPage - 1) * filterState.productsPerPage;
        const endIdx = startIdx + filterState.productsPerPage;
        const paginatedProducts = filtered.slice(startIdx, endIdx);

        // Mostrar produtos da página atual
        paginatedProducts.forEach(p => {
            productListing.appendChild(p.element);
        });

        // Atualizar contador com formatação correta
        const totalCount = filtered.length;
        const startCount = startIdx + 1;
        const endCount = Math.min(endIdx, totalCount);

        const counter = document.getElementById('filter-counter');
        if (counter) {
            counter.textContent = `Exibindo ${startCount}-${endCount} de ${totalCount} Produto(s)`;
        }
    }

    function renderPagination(filtered) {
        if (!pagination) return;

        const totalPages = Math.ceil(filtered.length / filterState.productsPerPage);
        const paginationLinks = pagination.querySelectorAll('.page-link');

        // Atualizar links de paginação
        paginationLinks.forEach(link => {
            if (link.textContent === '← Voltar') {
                link.style.display = filterState.currentPage > 1 ? '' : 'none';
                link.onclick = (e) => {
                    e.preventDefault();
                    if (filterState.currentPage > 1) {
                        filterState.currentPage--;
                        applyFilters();
                    }
                };
            } else if (link.textContent === 'Próximo →') {
                link.style.display = filterState.currentPage < totalPages ? '' : 'none';
                link.onclick = (e) => {
                    e.preventDefault();
                    if (filterState.currentPage < totalPages) {
                        filterState.currentPage++;
                        applyFilters();
                    }
                };
            } else if (!isNaN(parseInt(link.textContent))) {
                const pageNum = parseInt(link.textContent);
                link.style.display = pageNum <= totalPages ? '' : 'none';
                link.classList.toggle('active', pageNum === filterState.currentPage);
                link.onclick = (e) => {
                    e.preventDefault();
                    filterState.currentPage = pageNum;
                    applyFilters();
                };
            }
        });
    }

    // Inicializar
    captureAllProducts();
    applyFilters();
});
