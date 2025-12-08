#!/bin/bash

# Script para configurar o banco de dados Laravel

echo "=== Configurando banco de dados ==="

cd ~/Documentos/SENAC/PI/3-SEMESTRE/Projeto-Integrador---3-Semestre/Projeto-Integrador-3-Semeste

# Executa as migrações para criar as tabelas
php artisan migrate

echo ""
echo "=== Banco de dados configurado com sucesso! ==="
echo "Agora você pode executar: php artisan serve"
