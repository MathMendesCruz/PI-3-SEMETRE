# 🚀 Como Executar os Comandos Artisan no Hostinger

Você não tem SSH ou Terminal Web, mas tem **GIT**! Aqui está a solução:

## ⚡ Solução Rápida: Script de Pós-Deploy

Criei um arquivo `post-deploy.php` que executa automaticamente todos os comandos necessários.

### Como usar:

1. **Faça o commit e push do arquivo**:
```bash
git add post-deploy.php .env
git commit -m "Atualizar .env para MySQL e adicionar pós-deploy"
git push origin main
```

2. **No Hostinger, vá para GIT**:
   - Painel → Avançado → GIT
   - Clique em "Deploy" para fazer pull das mudanças
   - Aguarde o deploy ser concluído

3. **Execute o script no navegador**:
```
https://seu-dominio.com.br/post-deploy.php?token=7e0fd0f3c26e3d3cf64aceb80ba6b8c0
```

4. **Veja o resultado**:
   - ✅ Cache limpado
   - ✅ Configuração atualizada
   - ✅ Banco de dados conectado
   - ✅ Migrations executadas
   - ✅ Permissões ajustadas

---

## 🔒 Segurança

O token (`7e0fd0f3c26e3d3cf64aceb80ba6b8c0`) é derivado de:
```php
md5('elegance_joias_deploy_2025')
```

Após executar, **delete o arquivo** por segurança:
```bash
rm post-deploy.php
```

---

## 📋 Passo a Passo Completo

### 1️⃣ No seu computador local:

```bash
cd seu-projeto-laravel

# Verificar status Git
git status

# Adicionar arquivos modificados
git add .env post-deploy.php

# Fazer commit
git commit -m "Configurar MySQL no Hostinger"

# Fazer push
git push origin main
```

### 2️⃣ No Painel Hostinger:

1. Acesse o Painel
2. Vá para **Avançado** → **GIT**
3. Encontre seu repositório
4. Clique em **Deploy** ou **Pull**
5. Aguarde a mensagem de sucesso

### 3️⃣ No navegador:

Acesse:
```
https://seu-dominio.com.br/post-deploy.php?token=7e0fd0f3c26e3d3cf64aceb80ba6b8c0
```

Veja todos os comandos sendo executados em tempo real!

### 4️⃣ Teste seu site:

```
https://seu-dominio.com.br
```

---

## ❓ Problemas?

Se o script mostrar erro de conexão:

1. **Verifique o .env**:
   - DB_HOST deve ser: `localhost`
   - DB_DATABASE deve ser: `u932241504_banco_pi`
   - DB_USERNAME deve ser: `u932241504_usuario_senac`

2. **Verifique as permissões**:
   ```bash
   # No Hostinger → Avançado → Restaurar permissões de arquivos
   # Clique em "Restaurar"
   ```

3. **Verifique o banco**:
   - Painel → Banco de Dados → MySQL
   - Confirme que `u932241504_banco_pi` existe
   - Confirme que `u932241504_usuario_senac` tem permissões

---

## 🎯 Resumo

| Passo | O que fazer | Onde |
|-------|-----------|------|
| 1 | Commit e Push | Git local |
| 2 | Deploy | Painel Hostinger → GIT |
| 3 | Executar script | Navegador (post-deploy.php) |
| 4 | Testar | Acessar site |

**Tempo total: ~5 minutos** ⏱️

---

Pronto! Siga esses passos e seu site estará 100% funcional em MySQL no Hostinger! 🚀
