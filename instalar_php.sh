#!/bin/bash

# Script para instalar PHP e dependências necessárias para Laravel

echo "=== Instalando PHP e extensões para Laravel ==="

# Atualiza os repositórios
sudo apt update

# Instala PHP e extensões necessárias para Laravel
sudo apt install -y php php-cli php-common php-mbstring php-xml php-zip php-curl php-mysql php-pgsql php-sqlite3 php-bcmath php-intl php-gd php-tokenizer php-json

# Instala Composer (gerenciador de dependências PHP)
if ! command -v composer &> /dev/null; then
    echo "=== Instalando Composer ==="
    cd ~
    curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
    sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
fi

# Verifica a instalação
echo ""
echo "=== Verificando instalação ==="
php --version
composer --version

echo ""
echo "=== Instalação concluída! ==="
echo "Agora você pode executar: php artisan serve"
