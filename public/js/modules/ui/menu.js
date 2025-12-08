/**
 * Navigation Menu Module
 * Handles main navigation menu interactions
 */

export const MenuModule = {
    init() {
        this.setupMainMenu();
        this.setupMobileMenu();
    },

    setupMainMenu() {
        const navToggle = document.querySelector('[data-toggle="nav"]');
        const navMenu = document.querySelector('.nav-menu');

        if (navToggle && navMenu) {
            navToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.nav-menu') && !e.target.closest('[data-toggle="nav"]')) {
                    navMenu.classList.remove('active');
                }
            });
        }
    },

    setupMobileMenu() {
        const userMenuToggle = document.querySelector('.user-menu-toggle');
        const userMenuDropdown = document.querySelector('.user-menu-dropdown');

        if (!userMenuToggle || !userMenuDropdown) return;

        userMenuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenuDropdown.classList.toggle('visible');
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.user-menu')) {
                userMenuDropdown.classList.remove('visible');
            }
        });

        userMenuDropdown.addEventListener('click', (e) => {
            if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON') {
                userMenuDropdown.classList.remove('visible');
            }
        });
    }
};
