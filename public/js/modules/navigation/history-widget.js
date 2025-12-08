/**
 * History Widget Module
 * Exibe histórico de navegação visualmente para o usuário
 */

import { HistoryManager } from './history-manager.js';

export const HistoryWidget = {
    init() {
        this.createWidget();
        this.setupToggle();
    },

    /**
     * Cria o widget de histórico
     */
    createWidget() {
        const widget = document.createElement('div');
        widget.id = 'history-widget';
        widget.className = 'history-widget';
        widget.innerHTML = `
            <button class="history-toggle" aria-label="Ver histórico de navegação">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </button>
            <div class="history-panel" style="display: none;">
                <div class="history-header">
                    <h3>Páginas Recentes</h3>
                    <button class="history-close" aria-label="Fechar">×</button>
                </div>
                <div class="history-list"></div>
                <div class="history-footer">
                    <button class="history-clear-btn">Limpar Histórico</button>
                </div>
            </div>
        `;
        document.body.appendChild(widget);
    },

    /**
     * Configura botão de toggle
     */
    setupToggle() {
        const toggle = document.querySelector('.history-toggle');
        const panel = document.querySelector('.history-panel');
        const closeBtn = document.querySelector('.history-close');
        const clearBtn = document.querySelector('.history-clear-btn');

        if (toggle && panel) {
            toggle.addEventListener('click', () => {
                const isVisible = panel.style.display !== 'none';
                panel.style.display = isVisible ? 'none' : 'block';
                if (!isVisible) {
                    this.updateHistoryList();
                }
            });
        }

        if (closeBtn && panel) {
            closeBtn.addEventListener('click', () => {
                panel.style.display = 'none';
            });
        }

        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                if (confirm('Tem certeza que deseja limpar todo o histórico de navegação?')) {
                    HistoryManager.clearHistory();
                    this.updateHistoryList();
                }
            });
        }
    },

    /**
     * Atualiza lista de histórico
     */
    updateHistoryList() {
        const list = document.querySelector('.history-list');
        if (!list) return;

        const recentPages = HistoryManager.getRecentPages(10);
        const currentPath = window.location.pathname;

        if (recentPages.length === 0) {
            list.innerHTML = '<p class="history-empty">Nenhuma página visitada recentemente</p>';
            return;
        }

        list.innerHTML = recentPages
            .filter(page => page.pathname !== currentPath) // Remove página atual
            .map((page, index) => {
                const timeDiff = this.getTimeAgo(page.timestamp);
                return `
                    <a href="${page.url}" class="history-item">
                        <div class="history-item-content">
                            <span class="history-item-title">${page.title}</span>
                            <span class="history-item-time">${timeDiff}</span>
                        </div>
                    </a>
                `;
            })
            .join('');
    },

    /**
     * Calcula tempo decorrido
     */
    getTimeAgo(timestamp) {
        const now = new Date();
        const past = new Date(timestamp);
        const diffMs = now - past;
        const diffMins = Math.floor(diffMs / 60000);
        const diffHours = Math.floor(diffMs / 3600000);
        const diffDays = Math.floor(diffMs / 86400000);

        if (diffMins < 1) return 'Agora';
        if (diffMins < 60) return `${diffMins} min atrás`;
        if (diffHours < 24) return `${diffHours}h atrás`;
        if (diffDays === 1) return 'Ontem';
        if (diffDays < 7) return `${diffDays} dias atrás`;
        return past.toLocaleDateString('pt-BR');
    }
};
