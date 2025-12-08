/**
 * Brands Bar Carousel Module
 * Handles infinite scroll animation with pause on hover
 */

export const BrandsBarModule = {
    init() {
        const brandsBar = document.querySelector('.brands-bar');
        const scrollContent = document.querySelector('.brands-scroll-content');

        if (!brandsBar || !scrollContent) return;

        this.setupAnimation(brandsBar, scrollContent);
        this.setupBrandFiltering(scrollContent);
    },

    setupAnimation(brandsBar, scrollContent) {
        brandsBar.addEventListener('mouseenter', () => {
            scrollContent.classList.add('paused');
        });

        brandsBar.addEventListener('mouseleave', () => {
            scrollContent.classList.remove('paused');
        });
    },

    setupBrandFiltering(scrollContent) {
        const brandSpans = scrollContent.querySelectorAll('span[data-brand]');
        brandSpans.forEach(span => {
            span.addEventListener('click', (e) => {
                e.preventDefault();
                const brand = span.getAttribute('data-brand');
                const category = span.getAttribute('data-category');
                
                if (category === 'feminino') {
                    window.location.href = `/feminino?brand=${encodeURIComponent(brand)}`;
                } else if (category === 'masculino') {
                    window.location.href = `/masculino?brand=${encodeURIComponent(brand)}`;
                }
            });
        });
    }
};
