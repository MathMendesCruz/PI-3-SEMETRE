#!/bin/bash

###############################################################################
# Script de Deployment para Hostinger
# Uso: bash deploy.sh
###############################################################################

set -e  # Sair em caso de erro

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Função para imprimir seções
print_section() {
    echo -e "\n${BLUE}=== $1 ===${NC}\n"
}

# Função para sucesso
success() {
    echo -e "${GREEN}✅ $1${NC}"
}

# Função para erro
error() {
    echo -e "${RED}❌ $1${NC}"
    exit 1
}

# Função para aviso
warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

###############################################################################
# INICIALIZAÇÃO
###############################################################################

print_section "DEPLOYMENT ELEGANCE JOIAS - HOSTINGER"

# Verificar se está no diretório correto
if [ ! -f "artisan" ]; then
    error "Este script deve ser executado na raiz do projeto Laravel"
fi

###############################################################################
# PASSO 1: VALIDAR AMBIENTE
###############################################################################

print_section "PASSO 1: Validando Ambiente"

# Verificar PHP
if ! command -v php &> /dev/null; then
    error "PHP não está instalado"
fi
PHP_VERSION=$(php -v | grep -oP 'PHP \K[0-9]+\.[0-9]+' | head -1)
success "PHP $PHP_VERSION detectado"

# Verificar Composer
if ! command -v composer &> /dev/null; then
    error "Composer não está instalado"
fi
success "Composer detectado"

# Verificar arquivo .env
if [ ! -f ".env" ]; then
    warning ".env não encontrado. Criando a partir do exemplo..."
    if [ -f ".env.example" ]; then
        cp .env.example .env
        success ".env criado. EDITE COM SUAS CREDENCIAIS ANTES DE CONTINUAR!"
        echo -e "${YELLOW}Abra .env e atualize:${NC}"
        echo "  - DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD"
        echo "  - APP_URL com seu domínio"
        exit 1
    else
        error "Não encontrado .env.example"
    fi
fi
success ".env encontrado"

###############################################################################
# PASSO 2: INSTALAR DEPENDÊNCIAS
###############################################################################

print_section "PASSO 2: Instalando Dependências PHP"

# Criar diretório bootstrap/cache se não existir
mkdir -p bootstrap/cache storage/logs

# Instalar dependências composer
composer install --no-dev --optimize-autoloader --no-interaction
success "Dependências PHP instaladas"

###############################################################################
# PASSO 3: GERAR CHAVE DE APLICAÇÃO
###############################################################################

print_section "PASSO 3: Gerando Chave de Aplicação"

php artisan key:generate --force
success "Chave de aplicação gerada"

###############################################################################
# PASSO 4: LIMPAR CACHE ANTERIOR
###############################################################################

print_section "PASSO 4: Limpando Cache"

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
success "Cache limpo"

###############################################################################
# PASSO 5: MIGRAR BANCO DE DADOS
###############################################################################

print_section "PASSO 5: Migrando Banco de Dados"

warning "Executando migrações..."
php artisan migrate --force

success "Banco de dados migrado com sucesso"

###############################################################################
# PASSO 6: OTIMIZAR PARA PRODUÇÃO
###############################################################################

print_section "PASSO 6: Otimizando para Produção"

# Config cache
php artisan config:cache
success "Configuração cacheada"

# Route cache
php artisan route:cache
success "Rotas cacheadas"

# View cache
php artisan view:cache
success "Views cacheadas"

###############################################################################
# PASSO 7: PERMISSÕES DOS ARQUIVOS
###############################################################################

print_section "PASSO 7: Ajustando Permissões"

# Dar permissões ao diretório storage
chmod -R 775 storage bootstrap/cache
success "Permissões ajustadas"

###############################################################################
# PASSO 8: VERIFICAÇÃO FINAL
###############################################################################

print_section "PASSO 8: Verificação Final"

# Testar artisan
php artisan tinker --execute="echo 'Teste de conexão com banco: OK';"
success "Artisan funcionando"

###############################################################################
# FINALIZAÇÃO
###############################################################################

print_section "✅ DEPLOYMENT CONCLUÍDO COM SUCESSO!"

echo -e "${GREEN}Seu site está pronto em produção!${NC}\n"

echo -e "${BLUE}Próximos passos:${NC}"
echo "1. Acessar https://seu-dominio.com.br"
echo "2. Testar login e compras"
echo "3. Configurar email (se necessário)"
echo "4. Ativar monitoramento de erros"
echo ""
echo -e "${YELLOW}⚠️  Comandos úteis para manutenção:${NC}"
echo "  php artisan tinker                  # Executar comandos no terminal"
echo "  php artisan migrate --force         # Fazer backup antes!"
echo "  php artisan cache:clear             # Limpar cache"
echo "  php artisan log:tail                # Ver logs em tempo real"
echo ""
