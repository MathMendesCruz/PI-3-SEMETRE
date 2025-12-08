# 🚀 GUIA RÁPIDO - Deixe Tudo Funcional em 5 Minutos

## Pré-requisito
Estar na pasta do projeto:
```bash
cd /home/mathmendes/Documentos/SENAC/PI/3-SEMESTRE/Projeto-Integrador---3-Semestre/Projeto-Integrador-3-Semeste
```

---

## ⚡ Passo 1: Instalar Dependências

```bash
composer install
```

**Tempo:** 1-2 minutos  
**O que faz:** Baixa todas as bibliotecas PHP necessárias

---

## ⚡ Passo 2: Configurar Arquivo .env

```bash
cp .env.example .env
php artisan key:generate
```

**Tempo:** 10 segundos  
**O que faz:** Copia arquivo de configuração e gera chave da aplicação

---

## ⚡ Passo 3: Criar Banco de Dados

```bash
php artisan migrate:fresh --seed
```

**Tempo:** 5-10 segundos  
**O que faz:**
- Cria tabelas (users, products, sessions, etc)
- Popula 7 usuários de teste
- Popula 35 produtos de teste

**Credenciais de Teste:**
```
Email: matheus@example.com
Senha: senac123

(Outros usuários: felipe, arthur, wanessa, julia, wesley, claudio - todos @example.com)
```

---

## ⚡ Passo 4: Iniciar Servidor

```bash
php artisan serve
```

**Tempo:** Imediato  
**O que faz:** Inicia servidor Laravel em http://localhost:8000

---

## 🎉 Pronto! Tudo Funcional!

Abra seu navegador em: **http://localhost:8000**

---

## 🧪 Teste Rápido (30 segundos)

### 1. Login
```
URL: http://localhost:8000/login
Email: matheus@example.com
Senha: senac123
```

### 2. Ver Produtos
```
URL: http://localhost:8000/feminino
- Clique em um produto
- Veja os filtros funcionando
- Teste o sorting
```

### 3. Adicionar ao Carrinho
```
- Na página de detalhes
- Clique "Adicionar ao carrinho"
- Vá para /carrinho
```

### 4. Admin (Opcional)
```
URL: http://localhost:8000/adm/dashboard
- Login com same credentials
- Gerenciar produtos
```

---

## ❌ Se Algo Não Funcionar

### Erro: "Command 'php' not found"

**Solução:** PHP não está instalado
```bash
# Ubuntu/Debian
sudo apt-get install php php-cli php-mbstring php-xml php-curl

# macOS
brew install php
```

### Erro: "No such file or directory" (.env)

**Solução:**
```bash
touch .env
cp .env.example .env
php artisan key:generate
```

### Erro: "Database disk image malformed"

**Solução:** Limpar banco de dados
```bash
rm database/database.sqlite
php artisan migrate:fresh --seed
```

### Erro: "CSRF token mismatch"

**Solução:** Renovar sessão
```bash
php artisan cache:clear
php artisan config:clear
php artisan session:clear
```

### JavaScript não funciona

**Solução:**
```bash
# Abrir Console (F12) e procurar por erros
# Se houver erros, verificar:
# 1. Se app.js está carregando
# 2. Se modules estão sendo importados
# 3. Limpar cache do navegador (Ctrl+Shift+Del)
```

---

## 📂 Verificar Estrutura

Após executar os passos, sua pasta deve ter:

```
✅ .env                    (arquivo criado)
✅ database/database.sqlite (banco criado)
✅ node_modules/           (se npm install foi rodado)
✅ vendor/                 (dependências PHP)
✅ storage/framework/sessions (sessões)
```

---

## 🔐 Usuários de Teste

Use qualquer um destes:

| Email | Senha |
|-------|-------|
| matheus@example.com | senac123 |
| felipe@example.com | senac123 |
| arthur@example.com | senac123 |
| wanessa@example.com | senac123 |
| julia@example.com | senac123 |
| wesley@example.com | senac123 |
| claudio@example.com | senac123 |

---

## 📊 O Que Funciona

Após esses passos:

- ✅ **Autenticação** - Login, Cadastro, Logout
- ✅ **Produtos** - Homepage com 35 produtos
- ✅ **Feminino** - 15 produtos com filtros
- ✅ **Masculino** - 20 produtos com filtros
- ✅ **Filtros** - Por preço, marca, cor, categoria
- ✅ **Sorting** - 6 opções de ordenação
- ✅ **Carrinho** - Adicionar, remover, alterar quantidade
- ✅ **Admin** - Dashboard com CRUD
- ✅ **Design** - Responsivo em mobile, tablet, desktop

---

## 📚 Documentação Completa

Para mais detalhes, veja:

- `docs/SETUP-COMPLETO.md` - Guia detalhado
- `docs/GUIA-DE-TESTES.md` - Testes passo-a-passo
- `docs/FUNCIONALIDADES.md` - Lista de features
- `docs/CARRINHO-FUNCIONAL.md` - Detalhes carrinho
- `docs/CHECKLIST-FINAL.md` - Verificação final

---

## 🎯 Próximas Melhorias (Opcional)

```bash
# Instalar Node (para assets)
npm install
npm run dev

# Gerar chaves de API (se usar Stripe/etc)
php artisan inspire
```

---

## ✅ Resumo dos Passos

```bash
# 1. Dependências PHP
composer install

# 2. Configuração
cp .env.example .env
php artisan key:generate

# 3. Banco de dados
php artisan migrate:fresh --seed

# 4. Servidor
php artisan serve

# 5. Abrir navegador
# http://localhost:8000
```

**Pronto! Tudo funcional em ~2 minutos!** 🎉

---

## 💡 Dicas

1. **Servidor sempre rodando:** Deixe um terminal aberto com `php artisan serve`
2. **Console do navegador:** Pressione F12 para ver erros de JavaScript
3. **Banco novo:** Execute `php artisan migrate:fresh --seed` para resetar
4. **Cache:** `php artisan cache:clear` se houver problemas

---

## 📞 Suporte Rápido

| Problema | Solução |
|----------|---------|
| Erro de conexão | Verificar se `php artisan serve` está rodando |
| Banco não criado | Executar `php artisan migrate:fresh --seed` |
| Assets não carregam | Limpar cache (Ctrl+Shift+Del) |
| Login não funciona | Verificar se banco foi migrado |
| JavaScript erro | Abrir F12 e procurar por erros vermelhos |

---

**Sucesso! Seu projeto está 100% funcional! 🚀**

Aproveite e apresente com confiança!
