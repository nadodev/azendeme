# 📋 Requisitos Funcionais — Página Pública de Agendamento

## ✅ Status de Implementação

### RF07 – Exibição Inicial da Tela de Agendamento ✅

**Implementado:**
- ✅ Calendário bloqueado por padrão (overlay ativo)
- ✅ Listagem de serviços disponíveis exibida
- ✅ Mensagem orientativa no calendário: "Selecione um serviço para ver o calendário"

**Código:**
- `resources/views/public/sections/booking.blade.php` (linhas 22-25)
- `resources/views/public/sections/booking.blade.php` (função `setBookingState()`)

---

### RF08 – Seleção de Serviço ✅

**Implementado:**
- ✅ Sistema verifica se serviço possui funcionários vinculados
- ✅ Se **TEM** funcionários → exibe lista de funcionários correspondentes
- ✅ Se **NÃO TEM** funcionários → exibe opção "Profissional" (dono da página)
- ✅ Calendário permanece bloqueado até selecionar funcionário/profissional
- ✅ Mensagem atualiza para: "Selecione quem irá realizar o atendimento para ver o calendário"

**Código:**
- `resources/views/public/sections/booking.blade.php` (função `updateServiceSelection()`, linhas 211-304)
- Lógica de filtragem: verifica array `data-employees` de cada serviço
- Opção profissional: `<option value="professional" class="professional-option">` (linha 114)

**Como funciona:**
```javascript
// Se serviço TEM funcionários vinculados:
hasEmployees = true;
professionalOption.hidden = true; // Esconde opção "Profissional"
// Mostra apenas funcionários vinculados

// Se serviço NÃO TEM funcionários:
hasEmployees = false;
professionalOption.hidden = false; // Mostra opção "Profissional"
```

---

### RF09 – Seleção de Profissional ou Funcionário ✅

**Implementado:**
- ✅ Após selecionar funcionário/profissional → calendário desbloqueia
- ✅ Exibe dias disponíveis para aquele prestador
- ✅ Exibe horários disponíveis para o dia selecionado
- ✅ Disponibilidade específica do funcionário (se cadastrada) tem prioridade sobre disponibilidade geral

**Código:**
- `resources/views/public/sections/scripts.blade.php` (função `fetchTimeSlots()`, linhas 178-226)
- `app/Http/Controllers/PublicController.php` (método `getAvailableSlots()`, linhas 154-248)

**Lógica de Disponibilidade:**
```php
if ($employeeId && !$isProfessional) {
    // Busca disponibilidade específica do funcionário OU geral
    $availability = Availability::where('day_of_week', $dayOfWeek)
        ->where(function($q) use ($employeeId) {
            $q->where('employee_id', $employeeId)
              ->orWhereNull('employee_id');
        })
        ->orderByRaw('employee_id IS NOT NULL DESC') // Prioriza específica
        ->first();
} else {
    // Disponibilidade geral do profissional
    $availability = Availability::where('day_of_week', $dayOfWeek)
        ->whereNull('employee_id')
        ->first();
}
```

---

### RF10 – Formulário de Agendamento ✅

**Implementado:**
- ✅ Nome do cliente (obrigatório) - `<input required>`
- ✅ Telefone (obrigatório) - `<input required>`
- ✅ E-mail (opcional) - validado se preenchido
- ✅ Código de cupom (opcional)
- ✅ Formulário exibido sempre, mas só permite envio após selecionar:
  - Serviço ✅
  - Funcionário ou Profissional ✅
  - Dia e horário ✅

**Código:**
- `resources/views/public/sections/booking.blade.php` (linhas 132-147)
- Validações frontend: `resources/views/public/sections/scripts.blade.php` (linhas 307-333)

---

### RF11 – Envio do Agendamento ✅

**Implementado:**
- ✅ Registra agendamento no banco de dados
- ✅ Associa ao serviço escolhido
- ✅ Associa ao funcionário OU profissional selecionado
- ✅ Associa à data e horário escolhidos
- ✅ Associa ao cliente (dados do formulário)
- ✅ Valida código de cupom (se fornecido)
- ✅ Exibe mensagem de sucesso (modal)

**Código:**
- `app/Http/Controllers/PublicController.php` (método `book()`, linhas 250-373)
- `resources/views/public/sections/scripts.blade.php` (submit do form, linhas 301-380)

**Fluxo:**
1. Valida campos obrigatórios
2. Valida formato de email e telefone (RNF10)
3. Determina se é profissional (`is_professional: true`) ou funcionário (`employee_id: X`)
4. Verifica conflito de horário (RNF09)
5. Cria agendamento com `employee_id = null` (profissional) ou `employee_id = X` (funcionário)
6. Exibe modal de sucesso

---

## ⚙️ Requisitos Não Funcionais

### RNF06 – Interatividade ✅

**Implementado:**
- ✅ Calendário atualiza sem recarregar página (JavaScript/AJAX)
- ✅ Seleção de serviço → atualiza dropdown de funcionários dinamicamente
- ✅ Seleção de funcionário → atualiza calendário (desbloqueia)
- ✅ Seleção de data → busca horários via API REST (`fetch()`)
- ✅ Envio de formulário → via AJAX (sem recarregar)

---

### RNF07 – Responsividade ✅

**Implementado:**
- ✅ Grid adaptativo: `grid-cols-1 lg:grid-cols-2`
- ✅ Texto responsivo: `text-base lg:text-lg`, `text-3xl lg:text-4xl`
- ✅ Padding responsivo: `p-4 lg:p-8`, `py-12 lg:py-20`
- ✅ Botões responsivos: `w-4 h-4 lg:w-5 lg:h-5`
- ✅ Calendário: `max-h-60 lg:max-h-80`

**Código:**
- `resources/views/public/sections/booking.blade.php` (classes Tailwind em toda a view)

---

### RNF08 – Desempenho ✅

**Implementado:**
- ✅ Carregamento de serviços: direto do Blade (server-side, sem API)
- ✅ Carregamento de disponibilidade: API otimizada com índices no banco
- ✅ Queries com tenancy automático (evita dados desnecessários)
- ✅ Response JSON minimalista (apenas dados necessários)

**Otimizações:**
- Eager loading: `Service::with(['employees'])`
- Índices: `day_of_week`, `employee_id`, `professional_id`
- Cache de disponibilidade no mês (endpoint `/availability?month=X&year=Y`)

---

### RNF09 – Experiência do Usuário ✅

**Implementado:**
- ✅ Dias indisponíveis: `bg-gray-100 text-gray-400 cursor-not-allowed disabled`
- ✅ Dias disponíveis: `border-2 border-[var(--brand)] hover:bg-[var(--brand)]/10`
- ✅ Dia selecionado: `bg-[var(--brand)] text-white ring-2`
- ✅ Hoje: `ring-2 ring-blue-400`
- ✅ Legenda visual: "Disponível" vs "Indisponível"
- ✅ Evita duplo agendamento: verificação de conflito no backend

**Código:**
- Estilos visuais: `resources/views/public/sections/scripts.blade.php` (linhas 84-107)
- Conflito: `PublicController.php` (linhas 223-237, 317-325)

---

### RNF10 – Validação ✅

**Implementado:**
- ✅ **Nome:** obrigatório (`required`)
- ✅ **Telefone:** obrigatório + validação de formato
  ```javascript
  const phoneRegex = /^[\d\s\(\)\-\+]+$/;
  if (!phoneRegex.test(phone) || phone.length < 10) { ... }
  ```
- ✅ **Email:** validação de formato (se preenchido)
  ```javascript
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (email && !emailRegex.test(email)) { ... }
  ```
- ✅ **Backend:** Laravel validation rules
  ```php
  'name' => 'required|string|max:255',
  'phone' => 'required|string|max:20',
  'email' => 'nullable|email|max:255',
  ```

**Código:**
- Frontend: `resources/views/public/sections/scripts.blade.php` (linhas 315-333)
- Backend: `app/Http/Controllers/PublicController.php` (linhas 255-271)

---

## 🧪 Como Testar

### 1. Acesse a Página Pública

```
http://localhost/salao-da-maria
http://localhost/clinica-dr-joao
```

### 2. RF07: Estado Inicial

- ✅ Calendário deve estar **bloqueado** (overlay visível)
- ✅ Serviços devem estar listados
- ✅ Mensagem: "Selecione um serviço para ver o calendário"

### 3. RF08: Seleção de Serviço

**Teste 1: Serviço COM funcionário (ex: "Corte de Cabelo")**
1. Marque o checkbox do serviço
2. ✅ Deve aparecer seção "Quem irá realizar o atendimento?"
3. ✅ Dropdown deve mostrar **APENAS** o(s) funcionário(s) vinculado(s)
4. ✅ Opção "Profissional" deve estar **OCULTA**
5. ✅ Calendário ainda **bloqueado**

**Teste 2: Serviço SEM funcionário (ex: "Escova Progressiva")**
1. Marque o checkbox do serviço
2. ✅ Deve aparecer seção "Quem irá realizar o atendimento?"
3. ✅ Dropdown deve mostrar **APENAS** a opção do profissional (ex: "Salão da Maria")
4. ✅ Funcionários devem estar **OCULTOS**
5. ✅ Calendário ainda **bloqueado**

### 4. RF09: Seleção de Funcionário/Profissional

1. Selecione o funcionário ou profissional no dropdown
2. ✅ Calendário deve **desbloquear** (overlay desaparece)
3. ✅ Dias disponíveis devem aparecer destacados
4. ✅ Mensagem deve sumir

**Teste de Disponibilidade:**
- Se selecionou **funcionário com disponibilidade específica** (ex: Ana - Sábado 09:00-14:00)
  - ✅ Sábado deve aparecer disponível
  - ✅ Horários devem ser 09:00, 09:30, 10:00, ..., 13:30
  
- Se selecionou **profissional**
  - ✅ Deve mostrar disponibilidade geral (ex: Segunda a Sexta 09:00-18:00)

### 5. RF10 e RF11: Formulário e Envio

1. Selecione uma data no calendário
2. ✅ Deve aparecer "Data selecionada: ..."
3. ✅ Deve carregar horários disponíveis

4. Selecione um horário
5. ✅ Botão deve destacar (azul)

6. Preencha o formulário:
   - Nome: "Teste Silva"
   - Telefone: "11999998888"
   - Email: "teste@email.com" (teste com email inválido → deve validar)

7. Clique em "Confirmar Agendamento"
8. ✅ Deve aparecer modal de sucesso
9. ✅ Agendamento deve aparecer no painel admin (`/painel/agenda`)

### 6. RNF09: Teste de Duplo Agendamento

1. Faça um agendamento para "Segunda 10:00" com "Ana Souza"
2. Em **OUTRA ABA/NAVEGADOR**, tente agendar o mesmo horário
3. ✅ O horário "10:00" **NÃO** deve aparecer mais como disponível
4. ✅ Se tentar forçar (via API), deve retornar erro 409 Conflict

---

## 📊 Fluxo Completo (Diagrama)

```
┌─────────────────────────────────────────────┐
│ PÁGINA PÚBLICA - Estado Inicial             │
│ - Calendário bloqueado (overlay)            │
│ - Lista de serviços visível                 │
└─────────────────────────────────────────────┘
                    ↓
        [Usuário seleciona serviço]
                    ↓
┌─────────────────────────────────────────────┐
│ RF08: Verificação de Funcionários           │
│                                             │
│ SE serviço.employees.length > 0:            │
│   → Mostra funcionários vinculados          │
│   → Esconde opção "Profissional"            │
│                                             │
│ SE serviço.employees.length === 0:          │
│   → Mostra apenas "Profissional"            │
│   → Esconde funcionários                    │
│                                             │
│ Calendário AINDA bloqueado                  │
└─────────────────────────────────────────────┘
                    ↓
    [Usuário seleciona funcionário/profissional]
                    ↓
┌─────────────────────────────────────────────┐
│ RF09: Desbloqueio do Calendário             │
│ - Remove overlay                            │
│ - Busca disponibilidade do prestador        │
│ - Exibe dias disponíveis (destaque verde)   │
└─────────────────────────────────────────────┘
                    ↓
          [Usuário seleciona data]
                    ↓
┌─────────────────────────────────────────────┐
│ RF09: Carregamento de Horários              │
│ - API: /available-slots?date=...&employee_id=...│
│ - Backend verifica disponibilidade          │
│ - Backend verifica conflitos                │
│ - Retorna array de horários livres          │
└─────────────────────────────────────────────┘
                    ↓
         [Usuário seleciona horário]
                    ↓
        [Usuário preenche formulário]
                    ↓
┌─────────────────────────────────────────────┐
│ RF10/RNF10: Validação                       │
│ - Nome obrigatório ✓                        │
│ - Telefone obrigatório + formato ✓          │
│ - Email formato válido (se preenchido) ✓    │
└─────────────────────────────────────────────┘
                    ↓
       [Usuário clica "Confirmar Agendamento"]
                    ↓
┌─────────────────────────────────────────────┐
│ RF11: Criação do Agendamento                │
│                                             │
│ 1. Busca/Cria cliente (phone)               │
│ 2. Calcula duração e preço total            │
│ 3. Verifica conflito (RNF09)                │
│ 4. Cria Appointment:                        │
│    - professional_id = X                    │
│    - employee_id = Y ou NULL (profissional) │
│    - service_id = Z                         │
│    - customer_id = W                        │
│    - start_time, end_time                   │
│ 5. Se múltiplos serviços → cria pivot       │
│ 6. Retorna sucesso                          │
└─────────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────────┐
│ Modal de Sucesso                            │
│ "Agendamento Confirmado!"                   │
│ - Detalhes do agendamento                   │
│ - Limpa formulário                          │
│ - Atualiza calendário                       │
└─────────────────────────────────────────────┘
```

---

## 🔍 Verificação no Banco de Dados

### Agendamento com Funcionário

```sql
SELECT 
    a.id,
    a.start_time,
    s.name as servico,
    e.name as funcionario,
    c.name as cliente,
    a.professional_id
FROM appointments a
INNER JOIN services s ON s.id = a.service_id
LEFT JOIN employees e ON e.id = a.employee_id
INNER JOIN customers c ON c.id = a.customer_id
WHERE a.employee_id IS NOT NULL;
```

**Resultado esperado:**
- Coluna `funcionario` preenchida
- `professional_id` correto (do tenant)

### Agendamento com Profissional (sem funcionário)

```sql
SELECT 
    a.id,
    a.start_time,
    s.name as servico,
    a.employee_id,
    c.name as cliente,
    p.name as profissional
FROM appointments a
INNER JOIN services s ON s.id = a.service_id
INNER JOIN customers c ON c.id = a.customer_id
INNER JOIN professionals p ON p.id = a.professional_id
WHERE a.employee_id IS NULL;
```

**Resultado esperado:**
- `employee_id` = NULL
- `profissional` = nome do profissional (ex: "Salão da Maria")

---

## ✅ Checklist Final

- [✅] RF07: Calendário bloqueado inicialmente
- [✅] RF08: Seleção de serviço → mostra funcionários OU profissional
- [✅] RF09: Seleção de funcionário/profissional → desbloqueia calendário
- [✅] RF09: Exibe dias e horários disponíveis
- [✅] RF10: Formulário com campos obrigatórios
- [✅] RF11: Envio e criação do agendamento
- [✅] RNF06: Interatividade (AJAX, sem recarregar)
- [✅] RNF07: Responsividade (mobile/tablet/desktop)
- [✅] RNF08: Desempenho (< 2s)
- [✅] RNF09: UX (dias indisponíveis bloqueados, evita duplo agendamento)
- [✅] RNF10: Validação (nome, email, telefone)

---

## 🎉 Sistema de Agendamento Público Completo!

Todos os requisitos funcionais (RF07-RF11) e não funcionais (RNF06-RNF10) foram implementados com sucesso! 🚀

