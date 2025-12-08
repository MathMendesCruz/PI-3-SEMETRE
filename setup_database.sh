#!/bin/bash

# Script para configurar o banco de dados com migrações e seeders

echo "=== Configurando banco de dados ==="

cd ~/Documentos/SENAC/PI/3-SEMESTRE/Projeto-Integrador---3-Semestre/Projeto-Integrador-3-Semeste

# Executa as migrações para criar as tabelas
echo "Executando migrações..."
php artisan migrate

echo ""
echo "Populando banco de dados com produtos..."
# Popula o banco com dados iniciais
php artisan db:seed

echo ""
echo "=== Banco de dados configurado com sucesso! ==="
echo "Você pode agora executar: php artisan serve"
