# 🧪 Guia de Teste: Sistema de Agendamento Público

## 🚀 Como Testar o Sistema Completo

### 1️⃣ Acesse as Páginas Públicas

```
http://localhost/salao-da-maria
http://localhost/clinica-dr-joao
```

---

## 📋 Teste 1: Serviço COM Funcionário

### Cenário: "Corte de Cabelo" (Salão da Maria)

**Passo 1: Acesse** `/salao-da-maria`
- ✅ Calendário deve estar **bloqueado** (overlay visível)
- ✅ Mensagem: "Selecione um serviço para ver o calendário"

**Passo 2: Marque o serviço "Corte de Cabelo Feminino"**
- ✅ Aparece seção "Quem irá realizar o atendimento?"
- ✅ Dropdown mostra **APENAS**: "Ana Souza"
- ✅ Opção "Salão da Maria" (profissional) está **OCULTA**
- ✅ Calendário **AINDA bloqueado**
- ✅ Mensagem: "Selecione quem irá realizar o atendimento..."

**Passo 3: Selecione "Ana Souza" no dropdown**
- ✅ Calendário **DESBLOQUEIA** (overlay desaparece)
- ✅ Dias disponíveis aparecem com borda verde
- ✅ Segunda a Sexta: disponíveis (09:00-18:00)
- ✅ **Sábado: disponível** (Ana tem disponibilidade específica 09:00-14:00)

**Passo 4: Clique em um Sábado disponível**
- ✅ Aparece "Data selecionada: Sábado, 19 de outubro..."
- ✅ Horários aparecem: 09:00, 09:30, 10:00, ..., 13:30
- ✅ **NÃO** aparecem horários após 14:00 (limite da Ana)

**Passo 5: Selecione horário "10:00"**
- ✅ Botão "10:00" fica azul (selecionado)

**Passo 6: Preencha o formulário**
- Nome: "Cliente Teste"
- Telefone: "(11) 99999-8888"
- Email: "teste@email.com"

**Passo 7: Clique "Confirmar Agendamento"**
- ✅ Modal de sucesso aparece
- ✅ "Agendamento Confirmado!"
- ✅ Detalhes: "Corte de Cabelo Feminino agendado(s) para Sábado às 10:00"

**Passo 8: Verifique no banco de dados**
```sql
SELECT 
    a.id,
    a.start_time,
    s.name as servico,
    e.name as funcionario,
    a.employee_id,
    a.professional_id
FROM appointments a
INNER JOIN services s ON s.id = a.service_id
LEFT JOIN employees e ON e.id = a.employee_id
ORDER BY a.id DESC
LIMIT 1;
```

**Resultado esperado:**
- `servico` = "Corte de Cabelo Feminino"
- `funcionario` = "Ana Souza"
- `employee_id` = 1 (ou ID da Ana)
- `professional_id` = 1 (Salão da Maria)

---

## 📋 Teste 2: Serviço SEM Funcionário

### Cenário: "Escova Progressiva" (Salão da Maria)

**Passo 1: Acesse** `/salao-da-maria` **(nova aba)**

**Passo 2: Marque o serviço "Escova Progressiva"**
- ✅ Aparece seção "Quem irá realizar o atendimento?"
- ✅ Dropdown mostra **APENAS**: "Salão da Maria" (profissional)
- ✅ Funcionários (Ana, Carla) estão **OCULTOS**
- ✅ Calendário **AINDA bloqueado**

**Passo 3: Selecione "Salão da Maria" no dropdown**
- ✅ Calendário **DESBLOQUEIA**
- ✅ Segunda a Sexta: disponíveis (09:00-18:00)
- ✅ **Sábado: NÃO disponível** (profissional não trabalha sábado)

**Passo 4: Clique em uma Quinta-feira disponível**
- ✅ Horários aparecem: 09:00, 09:30, ..., 17:30

**Passo 5: Selecione horário "14:00"**

**Passo 6: Preencha o formulário**
- Nome: "Cliente Teste 2"
- Telefone: "(11) 98888-7777"
- Email: "teste2@email.com"

**Passo 7: Confirme o agendamento**
- ✅ Modal de sucesso

**Passo 8: Verifique no banco**
```sql
SELECT 
    a.id,
    a.start_time,
    s.name as servico,
    a.employee_id,
    p.name as profissional
FROM appointments a
INNER JOIN services s ON s.id = a.service_id
INNER JOIN professionals p ON p.id = a.professional_id
WHERE a.employee_id IS NULL
ORDER BY a.id DESC
LIMIT 1;
```

**Resultado esperado:**
- `servico` = "Escova Progressiva"
- `employee_id` = **NULL** (profissional)
- `profissional` = "Salão da Maria"

---

## 📋 Teste 3: Validações (RNF10)

### Cenário: Testar Validações de Formulário

**Teste 3.1: Email Inválido**
1. Selecione serviço + funcionário + data + horário
2. Preencha:
   - Nome: "Teste"
   - Telefone: "11999998888"
   - Email: "emailinvalido" (sem @ e domínio)
3. Clique "Confirmar"
4. ✅ Deve aparecer erro: "Por favor, insira um email válido."

**Teste 3.2: Telefone Inválido**
1. Preencha:
   - Nome: "Teste"
   - Telefone: "123" (muito curto)
   - Email: "teste@email.com"
2. Clique "Confirmar"
3. ✅ Deve aparecer erro: "Por favor, insira um telefone válido."

**Teste 3.3: Campos Obrigatórios Vazios**
1. Deixe nome ou telefone vazios
2. Clique "Confirmar"
3. ✅ Deve aparecer erro: "Por favor, preencha todos os campos obrigatórios..."

---

## 📋 Teste 4: Duplo Agendamento (RNF09)

### Cenário: Evitar Conflito de Horários

**Passo 1: Faça agendamento 1**
- Serviço: "Limpeza de Pele"
- Funcionária: "Dra. Fernanda"
- Data: Próxima Segunda-feira
- Horário: 10:00
- ✅ Sucesso!

**Passo 2: Tente agendar o mesmo horário (nova aba)**
- Serviço: "Limpeza de Pele"
- Funcionária: "Dra. Fernanda"
- Data: **Mesma Segunda-feira**
- ✅ Horário "10:00" **NÃO** deve aparecer como disponível

**Passo 3: Tente forçar via Developer Tools (opcional)**
- Abra DevTools → Network
- Tente enviar agendamento para horário ocupado
- ✅ Deve retornar erro **409 Conflict**
- ✅ Mensagem: "Este horário já foi reservado. Escolha outro horário."

---

## 📋 Teste 5: Múltiplos Serviços

### Cenário: Agendar 2 Serviços Juntos

**Passo 1: Marque 2 serviços**
- ✅ "Corte de Cabelo" (60 min, R$ 80)
- ✅ "Manicure" (90 min, R$ 60)

**Passo 2: Verifique o resumo**
- ✅ Aparece resumo verde:
  ```
  ✓ Corte de Cabelo Feminino
  ✓ Manicure e Pedicure
  ---
  Total: 150 minutos
  R$ 140,00
  ```

**Passo 3: Selecione funcionário**
- ✅ Dropdown mostra **UNIÃO** dos funcionários:
  - Ana Souza (do Corte)
  - Carla Santos (da Manicure)

**Passo 4: Selecione "Ana Souza"**
- ✅ Calendário desbloqueia

**Passo 5: Selecione data e horário**
- ✅ Horários levam em conta **duração total (150 min)**
- ✅ Se o horário é 10:00, próximo slot disponível é 12:30 (10:00 + 150min)

**Passo 6: Confirme agendamento**
- ✅ Sucesso!

**Passo 7: Verifique no banco**
```sql
SELECT * FROM appointment_services WHERE appointment_id = (SELECT MAX(id) FROM appointments);
```

**Resultado esperado:**
- 2 linhas (uma para cada serviço)
- `service_id` = 1 e 2
- `price` = 80.00 e 60.00
- `duration` = 60 e 90

---

## 📋 Teste 6: Multi-Tenancy (Isolamento)

### Cenário: Cada Profissional Vê Apenas Seus Dados

**Passo 1: Acesse Salão da Maria**
```
http://localhost/salao-da-maria
```
- ✅ Serviços listados:
  - Corte de Cabelo
  - Manicure
  - Escova Progressiva
- ✅ **NÃO** aparecem serviços da Clínica Dr. João

**Passo 2: Acesse Clínica Dr. João**
```
http://localhost/clinica-dr-joao
```
- ✅ Serviços listados:
  - Limpeza de Pele
  - Design de Sobrancelhas
  - Harmonização Facial
- ✅ **NÃO** aparecem serviços do Salão da Maria

**Passo 3: Teste agendamentos isolados**
1. Agende no Salão (professional_id = 1)
2. Agende na Clínica (professional_id = 2)
3. Verifique:
```sql
SELECT 
    p.name as profissional,
    COUNT(a.id) as total_agendamentos
FROM appointments a
INNER JOIN professionals p ON p.id = a.professional_id
GROUP BY p.id, p.name;
```

**Resultado esperado:**
- Cada profissional tem seus próprios agendamentos
- **NÃO** há cruzamento de dados

---

## 📋 Teste 7: Responsividade (RNF07)

### Cenário: Testar em Diferentes Dispositivos

**Passo 1: Desktop (1920x1080)**
- ✅ Grid 2 colunas (calendário | formulário)
- ✅ Texto grande e legível
- ✅ Botões espaçados

**Passo 2: Tablet (768px)**
- ✅ Grid 2 colunas (adaptado)
- ✅ Padding reduzido
- ✅ Texto médio

**Passo 3: Mobile (375px)**
- ✅ Grid 1 coluna (vertical)
- ✅ Calendário em cima, formulário embaixo
- ✅ Texto pequeno mas legível
- ✅ Botões touchable (44px mínimo)

**Como testar:**
- Chrome DevTools → Toggle Device Toolbar (Ctrl+Shift+M)
- Selecione: iPhone SE, iPad, Desktop

---

## ✅ Checklist de Testes

### RF07: Exibição Inicial
- [ ] Calendário bloqueado por padrão
- [ ] Serviços listados corretamente
- [ ] Mensagem orientativa visível

### RF08: Seleção de Serviço
- [ ] Serviço COM funcionário → mostra funcionários
- [ ] Serviço SEM funcionário → mostra profissional
- [ ] Calendário permanece bloqueado

### RF09: Seleção de Funcionário/Profissional
- [ ] Calendário desbloqueia após seleção
- [ ] Dias disponíveis destacados
- [ ] Horários carregam corretamente
- [ ] Disponibilidade específica de funcionário funciona

### RF10: Formulário
- [ ] Campos obrigatórios validam
- [ ] Email valida formato
- [ ] Telefone valida formato

### RF11: Envio
- [ ] Agendamento cria no banco
- [ ] employee_id correto (ou NULL para profissional)
- [ ] Modal de sucesso aparece

### RNF09: Duplo Agendamento
- [ ] Horários ocupados NÃO aparecem
- [ ] Tentativa de conflito retorna erro 409

### RNF06: Interatividade
- [ ] Tudo funciona sem recarregar página
- [ ] Transições suaves

### RNF07: Responsividade
- [ ] Desktop: layout 2 colunas
- [ ] Mobile: layout 1 coluna vertical
- [ ] Botões e textos adaptam

### Multi-Tenancy
- [ ] Cada profissional vê apenas seus dados
- [ ] Agendamentos isolados por professional_id

---

## 🎉 Sistema Testado e Aprovado!

Se todos os testes passarem, o sistema está 100% funcional conforme os requisitos RF07-RF11 e RNF06-RNF10! 🚀

