/**
 * History Manager Module
 * Gerencia o histórico de navegação do usuário
 */

export const HistoryManager = {
    storageKey: 'elegance_navigation_history',
    maxHistorySize: 50,

    init() {
        this.trackPageVisit();
        this.setupBackButton();
        this.cleanOldHistory();
    },

    /**
     * Registra a visita da página atual
     */
    trackPageVisit() {
        const currentPage = {
            url: window.location.href,
            pathname: window.location.pathname,
            title: document.title,
            timestamp: new Date().toISOString(),
            scrollPosition: 0
        };

        // Salva posição de scroll antes de sair
        window.addEventListener('beforeunload', () => {
            this.updateScrollPosition();
        });

        // Adiciona ao histórico
        this.addToHistory(currentPage);
    },

    /**
     * Adiciona página ao histórico
     */
    addToHistory(page) {
        let history = this.getHistory();

        // Evita duplicatas consecutivas
        const lastPage = history[history.length - 1];
        if (lastPage && lastPage.pathname === page.pathname) {
            // Atualiza timestamp da página atual
            history[history.length - 1] = page;
        } else {
            history.push(page);
        }

        // Mantém apenas as últimas N páginas
        if (history.length > this.maxHistorySize) {
            history = history.slice(-this.maxHistorySize);
        }

        localStorage.setItem(this.storageKey, JSON.stringify(history));
    },

    /**
     * Obtém histórico completo
     */
    getHistory() {
        try {
            const history = localStorage.getItem(this.storageKey);
            return history ? JSON.parse(history) : [];
        } catch (error) {
            console.error('Erro ao ler histórico:', error);
            return [];
        }
    },

    /**
     * Obtém a página anterior
     */
    getPreviousPage() {
        const history = this.getHistory();
        // Retorna a penúltima página (a última é a atual)
        return history.length >= 2 ? history[history.length - 2] : null;
    },

    /**
     * Obtém últimas N páginas visitadas
     */
    getRecentPages(count = 10) {
        const history = this.getHistory();
        return history.slice(-count).reverse();
    },

    /**
     * Atualiza posição de scroll da página atual
     */
    updateScrollPosition() {
        const history = this.getHistory();
        if (history.length > 0) {
            history[history.length - 1].scrollPosition = window.scrollY;
            localStorage.setItem(this.storageKey, JSON.stringify(history));
        }
    },

    /**
     * Restaura posição de scroll se voltou para a página
     */
    restoreScrollPosition() {
        const currentPath = window.location.pathname;
        const history = this.getHistory();
        const currentPage = history.find(page => page.pathname === currentPath);
        
        if (currentPage && currentPage.scrollPosition) {
            setTimeout(() => {
                window.scrollTo(0, currentPage.scrollPosition);
            }, 100);
        }
    },

    /**
     * Volta para a página anterior
     */
    goBack() {
        // 1) Tenta usar nosso histórico persistido
        const history = this.getHistory();
        if (history.length >= 2) {
            // Remove página atual
            history.pop();
            // Pega a anterior e também remove para evitar loop
            const target = history.pop();
            localStorage.setItem(this.storageKey, JSON.stringify(history));
            if (target) {
                window.location.href = target.url;
                return;
            }
        }

        // 2) Fallback: histórico do navegador
        if (window.history.length > 1) {
            window.history.back();
            return;
        }

        // 3) Fallback final: referrer ou home
        if (document.referrer) {
            window.location.href = document.referrer;
            return;
        }

        window.location.href = '/';
    },

    /**
     * Configura botão de voltar
     */
    setupBackButton() {
        const backButtons = document.querySelectorAll('[data-history-back]');
        
        backButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.goBack();
            });

            // Mostra/esconde botão baseado no histórico
            const history = this.getHistory();
            if (history.length < 2 && !document.referrer && window.history.length <= 1) {
                button.style.display = 'none';
            }
        });
    },

    /**
     * Limpa histórico antigo (mais de 7 dias)
     */
    cleanOldHistory() {
        const history = this.getHistory();
        const sevenDaysAgo = new Date();
        sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7);

        const cleanedHistory = history.filter(page => {
            const pageDate = new Date(page.timestamp);
            return pageDate > sevenDaysAgo;
        });

        if (cleanedHistory.length !== history.length) {
            localStorage.setItem(this.storageKey, JSON.stringify(cleanedHistory));
        }
    },

    /**
     * Limpa todo o histórico
     */
    clearHistory() {
        localStorage.removeItem(this.storageKey);
    },

    /**
     * Obtém estatísticas de navegação
     */
    getStats() {
        const history = this.getHistory();
        const pages = {};

        history.forEach(page => {
            if (pages[page.pathname]) {
                pages[page.pathname].visits++;
                pages[page.pathname].lastVisit = page.timestamp;
            } else {
                pages[page.pathname] = {
                    url: page.url,
                    title: page.title,
                    visits: 1,
                    firstVisit: page.timestamp,
                    lastVisit: page.timestamp
                };
            }
        });

        return {
            totalVisits: history.length,
            uniquePages: Object.keys(pages).length,
            pages: pages,
            mostVisited: Object.entries(pages)
                .sort((a, b) => b[1].visits - a[1].visits)
                .slice(0, 5)
        };
    },

    /**
     * Exporta histórico para análise
     */
    exportHistory() {
        const history = this.getHistory();
        const stats = this.getStats();
        
        return {
            history: history,
            stats: stats,
            exportDate: new Date().toISOString()
        };
    },

    /**
     * Verifica se o usuário já visitou uma página específica
     */
    hasVisited(pathname) {
        const history = this.getHistory();
        return history.some(page => page.pathname === pathname);
    },

    /**
     * Obtém a última vez que visitou uma página
     */
    getLastVisit(pathname) {
        const history = this.getHistory();
        const visits = history.filter(page => page.pathname === pathname);
        return visits.length > 0 ? visits[visits.length - 1] : null;
    }
};
