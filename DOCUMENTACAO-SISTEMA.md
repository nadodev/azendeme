# 📋 DOCUMENTAÇÃO COMPLETA - SISTEMA AzendaMe

## 📌 ÍNDICE
1. [Visão Geral](#visão-geral)
2. [Tecnologias Utilizadas](#tecnologias-utilizadas)
3. [Estrutura do Banco de Dados](#estrutura-do-banco-de-dados)
4. [Páginas e Funcionalidades](#páginas-e-funcionalidades)
5. [Como Usar o Sistema](#como-usar-o-sistema)
6. [Rotas do Sistema](#rotas-do-sistema)
7. [Modelos e Relacionamentos](#modelos-e-relacionamentos)
8. [Controllers](#controllers)
9. [Credenciais de Acesso](#credenciais-de-acesso)
10. [Fluxo de Uso](#fluxo-de-uso)

---

## 🎯 VISÃO GERAL

O **AzendaMe** é um sistema completo de agendamento online para profissionais e pequenas empresas de serviços. Ele centraliza:
- ✅ Agenda de atendimentos
- ✅ Cadastro de clientes
- ✅ Gerenciamento de serviços
- ✅ Controle de disponibilidade
- ✅ Relatórios e estatísticas
- ✅ Página pública de agendamento
- ✅ Sistema de autenticação completo

### 📊 Arquitetura
- **Single-tenant**: Uma instalação por profissional
- **Responsivo**: Funciona em desktop, tablet e mobile
- **Moderno**: Interface clean com Tailwind CSS
- **Seguro**: Autenticação Laravel Breeze

---

## 💻 TECNOLOGIAS UTILIZADAS

### Backend
- **Laravel 11.x** - Framework PHP
- **MySQL** - Banco de dados
- **Laravel Breeze** - Autenticação

### Frontend
- **Blade** - Template engine do Laravel
- **Tailwind CSS** - Framework CSS
- **Alpine.js** - JavaScript reativo
- **Vite** - Build tool

### Dependências
- **Carbon** - Manipulação de datas
- **Eloquent ORM** - Mapeamento objeto-relacional

---

## 🗄️ ESTRUTURA DO BANCO DE DADOS

### Tabela: `professionals`
Armazena os dados do profissional/negócio.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | bigint | Chave primária |
| name | string | Nome do profissional |
| slug | string | URL amigável (ex: beleza-da-ana) |
| email | string | Email do profissional |
| phone | string | Telefone |
| logo | string | Caminho da logo |
| brand_color | string | Cor da marca (hex) |
| business_name | string | Nome do negócio |
| bio | text | Biografia/descrição |
| subdomain | string | Subdomínio personalizado |
| active | boolean | Status ativo/inativo |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

### Tabela: `services`
Serviços oferecidos pelo profissional.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | bigint | Chave primária |
| professional_id | bigint | FK para professionals |
| name | string | Nome do serviço |
| description | text | Descrição |
| duration | integer | Duração em minutos |
| price | decimal | Preço (opcional) |
| active | boolean | Status ativo/inativo |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

### Tabela: `customers`
Clientes que agendaram serviços.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | bigint | Chave primária |
| professional_id | bigint | FK para professionals |
| name | string | Nome do cliente |
| phone | string | Telefone |
| email | string | Email (opcional) |
| notes | text | Observações |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

### Tabela: `appointments`
Agendamentos realizados.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | bigint | Chave primária |
| professional_id | bigint | FK para professionals |
| service_id | bigint | FK para services |
| customer_id | bigint | FK para customers |
| start_time | datetime | Horário de início |
| end_time | datetime | Horário de término |
| status | enum | pending, confirmed, cancelled, completed |
| notes | text | Observações |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

### Tabela: `availabilities`
Horários de disponibilidade semanal.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | bigint | Chave primária |
| professional_id | bigint | FK para professionals |
| day_of_week | integer | 0=Domingo, 1=Segunda, ..., 6=Sábado |
| start_time | time | Horário de início |
| end_time | time | Horário de término |
| slot_duration | integer | Duração dos intervalos (minutos) |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

### Tabela: `blocked_dates`
Datas bloqueadas (férias, feriados, etc).

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | bigint | Chave primária |
| professional_id | bigint | FK para professionals |
| blocked_date | date | Data bloqueada |
| reason | string | Motivo do bloqueio |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

### Tabela: `users`
Usuários do sistema (Laravel Breeze).

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | bigint | Chave primária |
| name | string | Nome do usuário |
| email | string | Email (login) |
| password | string | Senha (hash) |
| email_verified_at | timestamp | Verificação de email |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

---

## 📱 PÁGINAS E FUNCIONALIDADES

### 1. **Landing Page** (`/`)
- **Descrição**: Página institucional do AzendaMe
- **Funcionalidades**:
  - Hero com demonstração de calendário interativo
  - Recursos e benefícios
  - Demonstração interativa (Relatórios, Galeria, Lembretes)
  - Seção de público-alvo
  - Planos e preços
  - Depoimentos em carrossel
  - Call-to-action para cadastro
- **Arquivo**: `resources/views/landing.blade.php`
- **Acesso**: Público

### 2. **Página Pública do Profissional** (`/{slug}`)
- **Descrição**: Página personalizada para cada profissional
- **Funcionalidades**:
  - Exibição de serviços
  - Calendário de agendamento
  - Seleção de horários disponíveis
  - Formulário de agendamento
  - Galeria de trabalhos
- **Arquivo**: `resources/views/public.blade.php`
- **Controller**: `PublicController`
- **Exemplo**: `/beleza-da-ana`
- **Acesso**: Público

### 3. **Login** (`/login`)
- **Descrição**: Tela de autenticação
- **Funcionalidades**:
  - Login com email e senha
  - Link para recuperação de senha
  - Link para registro
- **Framework**: Laravel Breeze
- **Acesso**: Público

### 4. **Registro** (`/register`)
- **Descrição**: Cadastro de novos usuários
- **Funcionalidades**:
  - Criação de conta
  - Verificação de email
- **Framework**: Laravel Breeze
- **Acesso**: Público

### 5. **Dashboard** (`/panel`)
- **Descrição**: Visão geral do negócio
- **Funcionalidades**:
  - Cards com estatísticas (total agendamentos, pendentes, clientes, serviços)
  - Lista de próximos agendamentos
  - Gráfico de agendamentos mensais
- **Arquivo**: `resources/views/panel/dashboard.blade.php`
- **Controller**: `DashboardController`
- **Acesso**: Autenticado

### 6. **Agenda** (`/panel/agenda`)
- **Descrição**: Gerenciamento de agendamentos
- **Funcionalidades**:
  - Listagem de agendamentos
  - Filtros por data, serviço e status
  - Criar novo agendamento
  - Editar agendamento
  - Alterar status (pendente, confirmado, cancelado, concluído)
  - Excluir agendamento
  - Adicionar observações
- **Arquivo**: `resources/views/panel/agenda.blade.php`
- **Controller**: `AgendaController`
- **Acesso**: Autenticado

### 7. **Clientes** (`/panel/clientes`)
- **Descrição**: Gerenciamento de clientes
- **Funcionalidades**:
  - Listagem de clientes
  - Busca por nome, telefone ou email
  - Ver histórico de atendimentos
  - Adicionar/editar/excluir clientes
  - Visualizar total de agendamentos por cliente
  - Adicionar observações
- **Arquivo**: `resources/views/panel/clientes.blade.php`
- **Controller**: `CustomerController`
- **Acesso**: Autenticado

### 8. **Serviços** (`/panel/servicos`)
- **Descrição**: Gerenciamento de serviços
- **Funcionalidades**:
  - Grid de serviços
  - Cadastrar novo serviço
  - Editar serviço
  - Excluir serviço
  - Ativar/desativar serviço
  - Definir nome, descrição, duração e preço
- **Arquivo**: `resources/views/panel/servicos.blade.php`
- **Controller**: `ServiceController`
- **Acesso**: Autenticado

### 9. **Disponibilidade** (`/panel/disponibilidade`)
- **Descrição**: Controle de horários de atendimento
- **Funcionalidades**:
  - Definir horários por dia da semana
  - Configurar intervalo entre atendimentos
  - Bloquear datas específicas (férias, feriados)
  - Remover bloqueios
  - Visualização semanal
- **Arquivo**: `resources/views/panel/disponibilidade.blade.php`
- **Controller**: `AvailabilityController`
- **Acesso**: Autenticado

### 10. **Relatórios** (`/panel/relatorios`)
- **Descrição**: Estatísticas e performance
- **Funcionalidades**:
  - Filtro por período
  - Total de agendamentos
  - Taxa de cancelamento
  - Receita estimada
  - Agendamentos por status (gráfico)
  - Serviços mais procurados
  - Horários de pico
- **Arquivo**: `resources/views/panel/relatorios.blade.php`
- **Controller**: `ReportController`
- **Acesso**: Autenticado

### 11. **Configurações** (`/panel/configuracoes`)
- **Descrição**: Personalização do perfil e negócio
- **Funcionalidades**:
  - Editar dados do profissional
  - Upload de logo
  - Escolher cor da marca
  - Editar biografia
  - Visualizar e copiar link público
- **Arquivo**: `resources/views/panel/configuracoes.blade.php`
- **Controller**: `SettingsController`
- **Acesso**: Autenticado

---

## 🚀 COMO USAR O SISTEMA

### Instalação e Configuração

1. **Clone o repositório e instale dependências:**
```bash
composer install
npm install
```

2. **Configure o arquivo `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agende_me
DB_USERNAME=root
DB_PASSWORD=
```

3. **Rode as migrations e seeders:**
```bash
php artisan migrate:fresh --seed
```

4. **Compile os assets:**
```bash
npm run dev
# ou para produção:
npm run build
```

5. **Inicie o servidor:**
```bash
php artisan serve
```

6. **Acesse o sistema:**
- Landing Page: `http://localhost:8000`
- Login: `http://localhost:8000/login`
- Painel: `http://localhost:8000/panel`
- Página Pública: `http://localhost:8000/beleza-da-ana`

---

## 🔐 CREDENCIAIS DE ACESSO

### Usuário Demo (criado pelo seeder)
- **Email**: admin@AzendaMe
- **Senha**: password

### Profissional Demo
- **Nome**: Beleza da Ana
- **Slug**: beleza-da-ana
- **URL Pública**: `http://localhost:8000/beleza-da-ana`

---

## 🌐 ROTAS DO SISTEMA

### Rotas Públicas

| Método | Rota | Nome | Descrição |
|--------|------|------|-----------|
| GET | `/` | home | Landing page |
| GET | `/{slug}` | public.show | Página pública do profissional |
| GET | `/{slug}/available-slots` | public.slots | API: horários disponíveis |
| POST | `/{slug}/book` | public.book | API: criar agendamento público |
| GET | `/login` | login | Tela de login |
| POST | `/login` | - | Processar login |
| GET | `/register` | register | Tela de registro |
| POST | `/register` | - | Processar registro |

### Rotas Autenticadas (Painel)

| Método | Rota | Nome | Descrição |
|--------|------|------|-----------|
| GET | `/panel` | panel.dashboard | Dashboard |
| GET | `/panel/agenda` | panel.agenda.index | Listar agendamentos |
| GET | `/panel/agenda/create` | panel.agenda.create | Formulário novo agendamento |
| POST | `/panel/agenda` | panel.agenda.store | Salvar agendamento |
| GET | `/panel/agenda/{id}` | panel.agenda.show | Ver agendamento |
| GET | `/panel/agenda/{id}/edit` | panel.agenda.edit | Editar agendamento |
| PUT | `/panel/agenda/{id}` | panel.agenda.update | Atualizar agendamento |
| DELETE | `/panel/agenda/{id}` | panel.agenda.destroy | Excluir agendamento |
| GET | `/panel/clientes` | panel.clientes.index | Listar clientes |
| GET | `/panel/clientes/create` | panel.clientes.create | Formulário novo cliente |
| POST | `/panel/clientes` | panel.clientes.store | Salvar cliente |
| GET | `/panel/clientes/{id}` | panel.clientes.show | Ver cliente |
| GET | `/panel/clientes/{id}/edit` | panel.clientes.edit | Editar cliente |
| PUT | `/panel/clientes/{id}` | panel.clientes.update | Atualizar cliente |
| DELETE | `/panel/clientes/{id}` | panel.clientes.destroy | Excluir cliente |
| GET | `/panel/servicos` | panel.servicos.index | Listar serviços |
| GET | `/panel/servicos/create` | panel.servicos.create | Formulário novo serviço |
| POST | `/panel/servicos` | panel.servicos.store | Salvar serviço |
| GET | `/panel/servicos/{id}` | panel.servicos.show | Ver serviço |
| GET | `/panel/servicos/{id}/edit` | panel.servicos.edit | Editar serviço |
| PUT | `/panel/servicos/{id}` | panel.servicos.update | Atualizar serviço |
| DELETE | `/panel/servicos/{id}` | panel.servicos.destroy | Excluir serviço |
| GET | `/panel/disponibilidade` | panel.disponibilidade.index | Listar disponibilidade |
| GET | `/panel/disponibilidade/create` | panel.disponibilidade.create | Formulário nova disponibilidade |
| POST | `/panel/disponibilidade` | panel.disponibilidade.store | Salvar disponibilidade |
| PUT | `/panel/disponibilidade/{id}` | panel.disponibilidade.update | Atualizar disponibilidade |
| DELETE | `/panel/disponibilidade/{id}` | panel.disponibilidade.destroy | Excluir disponibilidade |
| POST | `/panel/disponibilidade/blocked-dates` | panel.disponibilidade.blocked-dates.store | Bloquear data |
| DELETE | `/panel/disponibilidade/blocked-dates/{id}` | panel.disponibilidade.blocked-dates.destroy | Desbloquear data |
| GET | `/panel/relatorios` | panel.relatorios.index | Ver relatórios |
| GET | `/panel/configuracoes` | panel.configuracoes.index | Ver configurações |
| POST | `/panel/configuracoes` | panel.configuracoes.update | Atualizar configurações |

---

## 🔗 MODELOS E RELACIONAMENTOS

### Professional
```php
// Relacionamentos
$professional->services()      // HasMany - Serviços do profissional
$professional->customers()     // HasMany - Clientes do profissional
$professional->appointments()  // HasMany - Agendamentos do profissional
$professional->availabilities()// HasMany - Horários disponíveis
$professional->blockedDates()  // HasMany - Datas bloqueadas
```

### Service
```php
// Relacionamentos
$service->professional()       // BelongsTo - Profissional dono do serviço
$service->appointments()       // HasMany - Agendamentos deste serviço
```

### Customer
```php
// Relacionamentos
$customer->professional()      // BelongsTo - Profissional do cliente
$customer->appointments()      // HasMany - Agendamentos do cliente
```

### Appointment
```php
// Relacionamentos
$appointment->professional()   // BelongsTo - Profissional do agendamento
$appointment->service()        // BelongsTo - Serviço agendado
$appointment->customer()       // BelongsTo - Cliente que agendou
```

### Availability
```php
// Relacionamentos
$availability->professional()  // BelongsTo - Profissional
```

### BlockedDate
```php
// Relacionamentos
$blockedDate->professional()   // BelongsTo - Profissional
```

---

## 🎮 CONTROLLERS

### 1. DashboardController
- **Namespace**: `App\Http\Controllers\Panel`
- **Responsabilidade**: Estatísticas gerais
- **Métodos**:
  - `index()` - Exibe dashboard com estatísticas

### 2. AgendaController
- **Namespace**: `App\Http\Controllers\Panel`
- **Responsabilidade**: CRUD de agendamentos
- **Métodos**:
  - `index()` - Lista agendamentos (com filtros)
  - `create()` - Formulário de criação
  - `store()` - Salva novo agendamento
  - `show()` - Exibe detalhes
  - `edit()` - Formulário de edição
  - `update()` - Atualiza agendamento
  - `destroy()` - Exclui agendamento

### 3. ServiceController
- **Namespace**: `App\Http\Controllers\Panel`
- **Responsabilidade**: CRUD de serviços
- **Métodos**: Resource completo (index, create, store, show, edit, update, destroy)

### 4. CustomerController
- **Namespace**: `App\Http\Controllers\Panel`
- **Responsabilidade**: CRUD de clientes
- **Métodos**: Resource completo com busca

### 5. AvailabilityController
- **Namespace**: `App\Http\Controllers\Panel`
- **Responsabilidade**: Gerenciar horários e datas bloqueadas
- **Métodos**:
  - Resource completo
  - `storeBlockedDate()` - Bloquear data
  - `destroyBlockedDate()` - Desbloquear data

### 6. ReportController
- **Namespace**: `App\Http\Controllers\Panel`
- **Responsabilidade**: Gerar relatórios e estatísticas
- **Métodos**:
  - `index()` - Exibe relatórios com filtros

### 7. SettingsController
- **Namespace**: `App\Http\Controllers\Panel`
- **Responsabilidade**: Configurações do perfil
- **Métodos**:
  - `index()` - Exibe formulário
  - `update()` - Salva alterações

### 8. PublicController
- **Namespace**: `App\Http\Controllers`
- **Responsabilidade**: Páginas públicas e agendamento
- **Métodos**:
  - `show($slug)` - Exibe página pública do profissional
  - `getAvailableSlots()` - API: retorna horários disponíveis
  - `book()` - API: processa agendamento público

---

## 📝 FLUXO DE USO

### 🔷 Fluxo do Profissional

1. **Cadastro e Login**
   - Acessa `/register`
   - Cria conta com email e senha
   - Faz login em `/login`

2. **Configuração Inicial**
   - Acessa `/panel/configuracoes`
   - Preenche dados do negócio
   - Faz upload da logo
   - Define cor da marca
   - Copia link público para compartilhar

3. **Cadastro de Serviços**
   - Acessa `/panel/servicos`
   - Clica em "Novo Serviço"
   - Preenche nome, descrição, duração e preço
   - Salva serviço

4. **Definir Disponibilidade**
   - Acessa `/panel/disponibilidade`
   - Adiciona horários para cada dia da semana
   - Define intervalos entre atendimentos
   - Bloqueia datas de férias/feriados

5. **Receber Agendamentos**
   - Compartilha link público nas redes sociais
   - Clientes agendam online
   - Recebe notificações no painel

6. **Gerenciar Agenda**
   - Acessa `/panel/agenda`
   - Visualiza agendamentos do dia
   - Confirma/cancela agendamentos
   - Adiciona observações

7. **Acompanhar Relatórios**
   - Acessa `/panel/relatorios`
   - Visualiza performance do negócio
   - Identifica serviços mais procurados
   - Analisa horários de pico

### 🔶 Fluxo do Cliente

1. **Acesso à Página Pública**
   - Cliente recebe link (ex: `AzendaMe/beleza-da-ana`)
   - Acessa a página

2. **Escolha do Serviço**
   - Visualiza serviços disponíveis
   - Seleciona o serviço desejado

3. **Seleção de Data e Horário**
   - Escolhe data no calendário
   - Sistema mostra horários disponíveis
   - Seleciona horário

4. **Preenchimento de Dados**
   - Informa nome, telefone e email
   - Adiciona observações (opcional)

5. **Confirmação**
   - Clica em "Agendar"
   - Recebe confirmação visual
   - Agendamento salvo no sistema

---

## 📂 ESTRUTURA DE ARQUIVOS

```
whitelabel/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Panel/
│   │       │   ├── AgendaController.php
│   │       │   ├── AvailabilityController.php
│   │       │   ├── CustomerController.php
│   │       │   ├── DashboardController.php
│   │       │   ├── ReportController.php
│   │       │   ├── ServiceController.php
│   │       │   └── SettingsController.php
│   │       └── PublicController.php
│   └── Models/
│       ├── Appointment.php
│       ├── Availability.php
│       ├── BlockedDate.php
│       ├── Customer.php
│       ├── Professional.php
│       ├── Service.php
│       └── User.php
├── database/
│   ├── migrations/
│   │   ├── 2025_10_13_144133_create_professionals_table.php
│   │   ├── 2025_10_13_144136_create_services_table.php
│   │   ├── 2025_10_13_144136_create_customers_table.php
│   │   ├── 2025_10_13_144137_create_appointments_table.php
│   │   ├── 2025_10_13_144138_create_availabilities_table.php
│   │   └── 2025_10_13_144139_create_blocked_dates_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── panel/
│       │   ├── layout.blade.php
│       │   ├── dashboard.blade.php
│       │   ├── agenda.blade.php
│       │   ├── clientes.blade.php
│       │   ├── servicos.blade.php
│       │   ├── disponibilidade.blade.php
│       │   ├── relatorios.blade.php
│       │   └── configuracoes.blade.php
│       ├── landing.blade.php
│       ├── public.blade.php
│       └── demo.blade.php
└── routes/
    └── web.php
```

---

## 🎨 DESIGN E INTERFACE

### Cores Padrão
- **Primária (Purple)**: #6C63FF
- **Secundária (Pink)**: #E91E63
- **Sucesso (Green)**: #10B981
- **Alerta (Amber)**: #F59E0B
- **Erro (Red)**: #EF4444
- **Info (Blue)**: #3B82F6

### Componentes Principais
- Cards com sombra suave
- Botões com gradiente
- Ícones Heroicons
- Formulários com foco em roxo
- Badges coloridos por status
- Tabelas responsivas
- Modais e alertas

---

## 🚀 PRÓXIMOS PASSOS (Futuros)

1. **Multi-tenant**: Suporte para múltiplos profissionais
2. **Notificações**: WhatsApp, SMS e Email automáticos
3. **Pagamentos Online**: Integração com Stripe/PagSeguro
4. **Google Agenda**: Sincronização bidirecional
5. **App Mobile**: Versão nativa iOS/Android
6. **Métricas Avançadas**: Dashboard com gráficos interativos
7. **Sistema de Comissões**: Para equipes
8. **Programas de Fidelidade**: Recompensas para clientes

---

## 📞 SUPORTE

Para dúvidas ou sugestões sobre o sistema, entre em contato através de:
- Email: suporte@AzendaMe
- Documentação: Este arquivo

---

**Desenvolvido com ❤️ para facilitar a vida de profissionais autônomos e pequenos negócios.**

