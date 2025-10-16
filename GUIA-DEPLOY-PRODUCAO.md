# 🚀 Guia de Deploy para Produção

## ⚠️ ERRO ATUAL

```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'user_id' in 'WHERE'
```

**Causa:** A migração que adiciona `user_id` à tabela `professionals` não foi executada em produção.

---

## 📋 Checklist de Deploy

### 1️⃣ Fazer Backup do Banco de Dados

```bash
# Em produção, criar backup antes de qualquer alteração
php artisan backup:run
# OU manualmente via phpMyAdmin/mysqldump
mysqldump -u usuario -p nome_banco > backup_$(date +%Y%m%d_%H%M%S).sql
```

### 2️⃣ Atualizar o Código

```bash
# Pull do repositório (ou upload via FTP/SFTP)
git pull origin main
# OU fazer upload dos arquivos atualizados via FTP
```

### 3️⃣ Executar Migrações

```bash
# IMPORTANTE: Executar as migrações
php artisan migrate --force

# Se der erro, tentar:
php artisan migrate:status  # Ver quais migrações faltam
```

### 4️⃣ Limpar Todos os Caches

```bash
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### 5️⃣ Recriar Caches (Opcional, para melhor performance)

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔧 Correções Aplicadas Nesta Sessão

### 1. **Rotas Públicas com Prefixo `/api/`**

Todas as rotas de API pública agora usam o prefixo `/api/`:

- ✅ `/api/{slug}/availability`
- ✅ `/api/{slug}/available-slots`
- ✅ `/api/{slug}/book`
- ✅ `/api/{slug}/validate-promo`
- ✅ `/api/{slug}/check-loyalty`

**Arquivos alterados:**
- `routes/web.php` - Rotas agrupadas com `Route::prefix('api')`
- `resources/views/public/sections/scripts.blade.php` - URLs atualizadas

### 2. **Correção do Bug 404 em `available-slots`**

**Problema:** Query string `service_ids=1` chegava como string "1" em vez de array, causando `Service::findOrFail(null)` → 404

**Solução:** Corrigida lógica de conversão de parâmetros em `PublicController::getAvailableSlots()`

```php
// Antes (BUG):
if (!is_array($serviceIds)) { 
    $serviceIds = $serviceId ? [$serviceId] : []; 
}
// Problema: $serviceIds = "1" → !is_array("1") = true → $serviceIds = null ? [null] : [] → []

// Depois (CORRIGIDO):
if (!is_array($serviceIds)) {
    if ($serviceIds) {
        $serviceIds = [$serviceIds]; // "1" → ["1"]
    } elseif ($serviceId) {
        $serviceIds = [$serviceId];
    } else {
        $serviceIds = [];
    }
}
```

### 3. **Multi-tenancy Corrigido**

- ✅ `SetTenantFromAuth` agora usa `user->professional->id` como tenant ID
- ✅ `PublicController` define tenant explicitamente: `Tenancy::setTenantId($professional->id)`
- ✅ Global scopes aplicados corretamente em todos os models tenant-aware

### 4. **Migração `user_id` em `professionals`**

A migração `2025_10_16_152240_add_user_id_to_professionals_table.php` adiciona:
- Coluna `user_id` com foreign key para `users`
- Índice em `user_id` para performance

---

## 🧪 Testar Após Deploy

### 1. Verificar se a coluna existe

```bash
php artisan tinker --execute="
    use Illuminate\Support\Facades\Schema;
    echo Schema::hasColumn('professionals', 'user_id') ? 'OK' : 'ERRO';
"
```

### 2. Testar página pública

```bash
# Acessar no navegador:
https://azendeme.com.br/beleza-da-ana

# Testar API diretamente:
curl https://azendeme.com.br/api/beleza-da-ana/availability?month=10&year=2025
```

### 3. Verificar rotas registradas

```bash
php artisan route:list --path=api
```

### 4. Verificar logs

```bash
tail -f storage/logs/laravel.log
```

---

## 🚨 Se Algo Der Errado

### Erro: "Column 'user_id' already exists"
```bash
# A migração já foi executada, apenas limpar cache
php artisan optimize:clear
```

### Erro: "Unknown column 'user_id'"
```bash
# A migração não foi executada
php artisan migrate --force
```

### Erro 500 genérico
```bash
# Verificar permissões
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Verificar logs
tail -100 storage/logs/laravel.log
```

### Página em branco / 500
```bash
# Ativar modo debug temporariamente (CUIDADO EM PRODUÇÃO)
# Editar .env:
APP_DEBUG=true

# Após identificar o erro, DESATIVAR:
APP_DEBUG=false
```

---

## 📊 Ordem de Execução Recomendada

```bash
# 1. Backup
mysqldump -u usuario -p nome_banco > backup.sql

# 2. Atualizar código
git pull origin main

# 3. Instalar dependências (se necessário)
composer install --no-dev --optimize-autoloader

# 4. Executar migrações
php artisan migrate --force

# 5. Limpar e recriar caches
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Testar
curl https://azendeme.com.br/api/beleza-da-ana/availability?month=10&year=2025
```

---

## ✅ Verificação Final

- [ ] Backup do banco criado
- [ ] Código atualizado em produção
- [ ] Migrações executadas (`php artisan migrate:status`)
- [ ] Coluna `user_id` existe em `professionals`
- [ ] Caches limpos
- [ ] Página pública funciona
- [ ] API `/api/{slug}/available-slots` retorna horários
- [ ] Logs sem erros

---

## 📝 Notas Importantes

1. **SEMPRE** faça backup antes de executar migrações em produção
2. As rotas antigas sem `/api/` **NÃO** funcionam mais - atualizar código obrigatório
3. O JavaScript espera URLs com `/api/` - deploy incompleto causará erros
4. Em produção, mantenha `APP_DEBUG=false` após testes
5. Se usar servidor compartilhado, verificar se `php artisan` está disponível

---

## 🆘 Suporte

Se após seguir todos os passos o erro persistir:

1. Verificar versão do PHP (mínimo 8.2)
2. Verificar extensões PHP: `pdo_mysql`, `mbstring`, `xml`, `curl`
3. Verificar logs do servidor web (Apache/Nginx)
4. Verificar se o `.env` em produção está correto

