# Correção de professional_id nos Registros

## 🔴 Problema Identificado

O sistema estava apresentando uma inconsistência onde:

- **User ID: 5**
- **Professional ID: 10**
- **Serviços mostrados:** `professional_id = 10` ❌
- **Serviços corretos:** `professional_id = 5` (dados antigos) ❌

### Causa Raiz:

Os registros antigos foram criados com `professional_id = user->id`, mas o sistema atual usa `professional_id = user->professional->id`.

**Exemplo:**
```
User:
  id: 5
  professional:
    id: 10

Registros antigos (ERRADO):
  services.professional_id = 5  (user_id)
  
Registros novos (CORRETO):
  services.professional_id = 10 (professional->id)
```

## ✅ Solução Implementada

### 1. Migration de Correção

Criada migration: `2025_10_16_153055_fix_professional_id_in_all_tables.php`

**O que faz:**
- Busca todos os usuários com professional
- Para cada usuário onde `user_id ≠ professional_id`:
  - Atualiza `professional_id` de `user_id` para `professional->id`
  - Corrige em TODAS as tabelas do sistema

### 2. Comando de Correção

Criado comando: `php artisan fix:professional-id`

**Uso:**
```bash
php artisan fix:professional-id
```

### 3. Script Manual

Criado script: `fix-professional-ids.php`

**Uso:**
```bash
php fix-professional-ids.php
```

## 📋 Tabelas Corrigidas

A correção foi aplicada em:

- ✅ services
- ✅ employees  
- ✅ customers
- ✅ appointments
- ✅ availabilities
- ✅ blocked_dates
- ✅ galleries
- ✅ events
- ✅ payment_methods
- ✅ financial_transactions
- ✅ (e todas as outras com professional_id)

## 🔍 Como Verificar se a Correção Foi Aplicada

### Passo 1: Verificar relação User → Professional

```sql
SELECT 
    u.id as user_id, 
    u.email, 
    p.id as professional_id 
FROM users u 
LEFT JOIN professionals p ON p.user_id = u.id;
```

### Passo 2: Verificar serviços

```sql
-- Antes da correção (dados incorretos):
SELECT * FROM services WHERE professional_id = 5; -- user_id

-- Depois da correção (dados corretos):
SELECT * FROM services WHERE professional_id = 10; -- professional->id
```

### Passo 3: Testar no Painel

1. Faça login com o usuário
2. Acesse `/painel/servicos`
3. Deve mostrar os serviços corretos
4. Verifique que `professional_id` nas queries é o ID do professional, não do user

## ⚙️ Como Executar a Correção

### Opção 1: Migration (Recomendado)

```bash
# Executar a migration
php artisan migrate

# Se já rodou e precisa rodar de novo:
php artisan migrate:refresh --path=database/migrations/2025_10_16_153055_fix_professional_id_in_all_tables.php
```

### Opção 2: Comando Artisan

```bash
php artisan fix:professional-id
```

### Opção 3: Script Manual

```bash
php fix-professional-ids.php
```

## 🎯 Entendendo a Lógica Correta

### Estrutura de Dados:

```
User (id: 5)
  └─> Professional (id: 10, user_id: 5)

Tenancy:
  - Middleware define: Tenancy::setTenantId(10)  // professional->id
  - Todas as queries filtram: WHERE professional_id = 10
```

### No Middleware:

```php
// ✅ CORRETO
public function handle(Request $request, Closure $next): Response
{
    $user = $request->user();
    if ($user && $user->professional) {
        Tenancy::setTenantId($user->professional->id); // usa professional->id
    }
    return $next($request);
}
```

### Nos Models:

```php
// Trait BelongsToTenant aplica:
WHERE professional_id = Tenancy::tenantId() // professional->id (10)
```

### No Banco:

```sql
-- TODOS os registros devem ter:
services.professional_id = 10        (professional->id)
employees.professional_id = 10       (professional->id)
customers.professional_id = 10       (professional->id)
-- NÃO usar user->id (5) ❌
```

## 🔒 Garantindo Consistência Futura

### 1. Trait BelongsToTenant

O trait já adiciona `professional_id` automaticamente ao criar registros:

```php
static::creating(function ($model) {
    $tenantId = Tenancy::tenantId();
    if ($tenantId && empty($model->professional_id)) {
        $model->professional_id = $tenantId; // professional->id correto
    }
});
```

### 2. Middleware

Sempre define o tenant correto:

```php
Tenancy::setTenantId($user->professional->id);
```

### 3. Controllers

NÃO filtram manualmente por professional_id:

```php
// ✅ CORRETO
$services = Service::all(); // tenancy filtra automaticamente

// ❌ ERRADO
$services = Service::where('professional_id', auth()->user()->id)->get();
```

## 🧪 Teste de Verificação

Execute este SQL para verificar se há inconsistências:

```sql
-- Deve retornar 0 linhas (sem inconsistências)
SELECT 
    u.id as user_id,
    p.id as professional_id,
    COUNT(s.id) as services_with_user_id
FROM users u
LEFT JOIN professionals p ON p.user_id = u.id
LEFT JOIN services s ON s.professional_id = u.id
WHERE u.id != p.id
  AND s.id IS NOT NULL
GROUP BY u.id, p.id;
```

Se retornar linhas, execute a correção novamente.

## 📚 Arquivos Relacionados

- `database/migrations/2025_10_16_153055_fix_professional_id_in_all_tables.php`
- `app/Console/Commands/FixProfessionalIdInRecords.php`
- `fix-professional-ids.php`
- `app/Http/Middleware/SetTenantFromAuth.php`
- `app/Models/Concerns/BelongsToTenant.php`

## ✅ Checklist de Verificação

- [ ] Migration executada: `php artisan migrate`
- [ ] Verificar no banco: `professional_id` correto nos registros
- [ ] Testar login no painel
- [ ] Verificar se serviços aparecem corretamente
- [ ] Verificar se employees aparecem corretamente
- [ ] Confirmar que `Tenancy::tenantId()` retorna `professional->id`

---

**Problema resolvido!** Agora o sistema usa `professional->id` consistentemente em todos os lugares. 🎉

