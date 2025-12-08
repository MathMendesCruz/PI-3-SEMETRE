#!/bin/bash

# Script para gerar a chave de aplicação Laravel

echo "=== Gerando chave de aplicação Laravel ==="

# Navega até o diretório do projeto
cd ~/Documentos/SENAC/PI/3-SEMESTRE/Projeto-Integrador---3-Semestre/Projeto-Integrador-3-Semeste

# Gera a chave de aplicação
php artisan key:generate

echo ""
echo "=== Chave gerada com sucesso! ==="
echo "Agora você pode executar: php artisan serve"
