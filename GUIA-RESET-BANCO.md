# Guia: Resetar e Popular Banco de Dados

## 🎯 Objetivo

Resetar completamente o banco de dados e popular com dados de teste seguindo os **Requisitos Funcionais (RF01-RF06)**.

---

## 📋 Requisitos Funcionais Implementados

### ✅ RF01 – Cadastro de Usuário e Profissional (1:1)
- Cada usuário tem **exatamente UM** professional vinculado
- Relação: `User.id` ↔ `Professional.user_id`

### ✅ RF02 – Autenticação
- Login com email e senha
- Redirecionamento ao painel administrativo

### ✅ RF03 – Cadastro de Funcionários
- **Campos obrigatórios:** Nome, Email, Telefone, CPF
- Vinculados ao professional (tenant)

### ✅ RF04 – Cadastro de Serviços
- Serviços **PODEM ou NÃO** ter funcionário vinculado
- Se vinculado: relação many-to-many via `employee_service`
- Se não vinculado: feito pelo profissional/dono

### ✅ RF05 – Cadastro de Disponibilidade
- Pode ser vinculada a:
  - **Funcionário específico** (`employee_id` preenchido)
  - **Profissional geral** (`employee_id = NULL`)

### ✅ RF06 – Agendamento
- Relaciona: Serviço + Funcionário/Profissional + Data/Hora + Cliente
- Se serviço tem funcionário → mostra funcionários
- Se serviço não tem funcionário → mostra profissional

---

## 🚀 Como Executar

### Opção 1: Comando Único (Recomendado)

```bash
php artisan db:fresh-seed
```

Este comando:
1. ⚠️ Apaga TODOS os dados do banco
2. 🔄 Executa todas as migrations novamente
3. 🌱 Popula com dados de teste dos 2 usuários

### Opção 2: Passo a Passo

```bash
# 1. Resetar migrations
php artisan migrate:fresh

# 2. Popular com dados
php artisan db:seed
```

---

## 👥 Dados Criados

### 📦 USUÁRIO 1: Salão da Maria

**Login:**
- Email: `maria@salao.com`
- Senha: `password`

**Estrutura:**
- User ID: será criado automaticamente
- Professional ID: vinculado ao user

**Funcionários (RF03):**
- **Ana Souza** (CPF: 123.456.789-01)
  - Email: ana@salaodamaria.com
  - Telefone: (11) 98888-1111
  
- **Carla Santos** (CPF: 987.654.321-09)
  - Email: carla@salaodamaria.com
  - Telefone: (11) 98888-2222

**Serviços (RF04):**
| Serviço | Vinculado a | Tipo |
|---------|-------------|------|
| Corte de Cabelo | Ana Souza | Funcionária |
| Manicure e Pedicure | Carla Santos | Funcionária |
| Escova Progressiva | - | Profissional (sem funcionário) |

**Disponibilidades (RF05):**
- Segunda a Sexta: 09:00-18:00 (Profissional geral)
- Sábado: 09:00-14:00 (Ana Souza - específica)

**Página Pública:** `/salao-da-maria`

---

### 📦 USUÁRIO 2: Clínica Dr. João

**Login:**
- Email: `joao@clinica.com`
- Senha: `password`

**Estrutura:**
- User ID: será criado automaticamente
- Professional ID: vinculado ao user

**Funcionários (RF03):**
- **Dra. Fernanda Lima** (CPF: 111.222.333-44)
  - Email: fernanda@clinicadrjoao.com
  - Telefone: (11) 97777-1111
  
- **Rafael Alves** (CPF: 555.666.777-88)
  - Email: rafael@clinicadrjoao.com
  - Telefone: (11) 97777-2222

**Serviços (RF04):**
| Serviço | Vinculado a | Tipo |
|---------|-------------|------|
| Limpeza de Pele | Dra. Fernanda | Funcionária |
| Design de Sobrancelhas | Rafael | Funcionário |
| Harmonização Facial | - | Profissional (Dr. João) |

**Disponibilidades (RF05):**
- Segunda a Sexta: 08:00-17:00 (Profissional geral)
- Sábado: 08:00-12:00 (Dra. Fernanda - específica)

**Página Pública:** `/clinica-dr-joao`

---

## 🧪 Como Testar o Isolamento (Multi-Tenancy)

### Teste 1: Isolamento no Painel

1. **Faça login com maria@salao.com**
   - Acesse `/painel/servicos`
   - Deve ver APENAS os 3 serviços do Salão da Maria
   
2. **Saia e faça login com joao@clinica.com**
   - Acesse `/painel/servicos`
   - Deve ver APENAS os 3 serviços da Clínica Dr. João

3. **Verifique funcionários**
   - Maria deve ver: Ana e Carla
   - João deve ver: Dra. Fernanda e Rafael

### Teste 2: Páginas Públicas (RF06 - Agendamento)

1. **Acesse `/salao-da-maria`**
   - Deve listar os 3 serviços
   - Ao selecionar "Corte de Cabelo" → deve mostrar "Ana Souza"
   - Ao selecionar "Escova Progressiva" → sem funcionário (profissional)
   
2. **Acesse `/clinica-dr-joao`**
   - Deve listar os 3 serviços
   - Ao selecionar "Limpeza de Pele" → deve mostrar "Dra. Fernanda"
   - Ao selecionar "Harmonização" → sem funcionário (Dr. João)

### Teste 3: Agendamento Completo (RF06)

1. Acesse a página pública
2. Selecione um serviço
3. Se o serviço tiver funcionário:
   - Deve aparecer opção de escolher o funcionário
   - Calendário mostra disponibilidade do funcionário
4. Se o serviço não tiver funcionário:
   - Calendário mostra disponibilidade do profissional
5. Escolha data e horário
6. Preencha dados do cliente
7. Confirme o agendamento

---

## 🔍 Verificação no Banco de Dados

### Verificar Relação User ↔ Professional

```sql
SELECT 
    u.id as user_id,
    u.email,
    p.id as professional_id,
    p.name as professional_name
FROM users u
INNER JOIN professionals p ON p.user_id = u.id;
```

**Resultado esperado:**
- User ID 1 → Professional ID X (Salão da Maria)
- User ID 2 → Professional ID Y (Clínica Dr. João)

### Verificar Serviços e Funcionários

```sql
-- Serviços COM funcionário vinculado
SELECT 
    s.name as servico,
    e.name as funcionario,
    s.professional_id
FROM services s
INNER JOIN employee_service es ON es.service_id = s.id
INNER JOIN employees e ON e.id = es.employee_id;

-- Serviços SEM funcionário (feitos pelo profissional)
SELECT 
    s.name as servico,
    s.professional_id
FROM services s
LEFT JOIN employee_service es ON es.service_id = s.id
WHERE es.id IS NULL;
```

### Verificar Disponibilidades

```sql
-- Disponibilidade do Profissional (geral)
SELECT * FROM availabilities WHERE employee_id IS NULL;

-- Disponibilidade de Funcionário Específico
SELECT 
    a.*,
    e.name as funcionario
FROM availabilities a
INNER JOIN employees e ON e.id = a.employee_id;
```

---

## ⚠️ Importante

1. **Backup**: O comando `db:fresh-seed` APAGA TUDO! Faça backup se necessário.

2. **Migrations Atualizadas**: Certifique-se de que executou:
   ```bash
   php artisan migrate
   ```

3. **CPF nos Funcionários**: Migration adicionada (`add_cpf_to_employees_table`)

4. **Tenancy Correto**: 
   - User ID ≠ Professional ID (geralmente)
   - Todos os registros usam `professional_id` (não `user_id`)

---

## 📚 Arquivos Relevantes

- `database/seeders/DatabaseSeeder.php` - Seeder principal
- `app/Console/Commands/FreshDatabase.php` - Comando de reset
- `database/migrations/*_add_cpf_to_employees_table.php` - CPF
- `app/Models/Employee.php` - Model com CPF
- `app/Http/Middleware/SetTenantFromAuth.php` - Tenancy middleware

---

## 🎉 Pronto para Testar!

Execute:

```bash
php artisan db:fresh-seed
```

E teste o sistema com os 2 usuários independentes! 🚀

