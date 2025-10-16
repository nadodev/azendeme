# Sistema de Roles e Multi-Tenancy

## 📋 Visão Geral

O sistema agora usa **Roles** (Funções) + **Multi-Tenancy** (por `professional_id`) para controlar acesso e isolamento de dados.

## 🔐 Roles Disponíveis

- **`usuario`** (padrão): Usuário comum do sistema
- **`admin`**: Administrador com acesso total

## 🏗️ Arquitetura

### 1. Estrutura de Dados

```
User (users)
├── id
├── name
├── email
├── role (usuario/admin)
└── professional (relationship) → Professional

Professional (professionals)
├── id
├── user_id (FK → users.id)
├── name
├── slug
└── ... (outros campos)

Services, Employees, etc. (tables)
├── id
├── professional_id (FK → professionals.id)
└── ... (outros campos)
```

### 2. Multi-Tenancy

**Como funciona:**
- Cada `User` possui um `Professional` associado
- O middleware `SetTenantFromAuth` define o `professional_id` do usuário logado como "tenant"
- O trait `BelongsToTenant` filtra automaticamente todos os dados pelo `professional_id`

**Exemplo:**
```php
// Middleware SetTenantFromAuth
Tenancy::setTenantId($user->professional->id);

// Trait BelongsToTenant aplica filtro global
Service::all(); // Retorna apenas services do professional_id logado
Employee::all(); // Retorna apenas employees do professional_id logado
```

## 🔧 Como Usar

### 1. Verificar Role do Usuário

```php
// No controller ou view
if (auth()->user()->isAdmin()) {
    // Lógica para admin
}

if (auth()->user()->isUsuario()) {
    // Lógica para usuário comum
}

// Genérico
if (auth()->user()->hasRole('usuario')) {
    // ...
}
```

### 2. Proteger Rotas com Middleware

```php
// No arquivo de rotas (routes/web.php)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
});

Route::middleware(['auth', 'role:usuario'])->group(function () {
    Route::get('/painel/servicos', [ServiceController::class, 'index']);
});
```

### 3. Controllers

Os controllers do painel **NÃO precisam** filtrar manualmente por `professional_id`:

**❌ ANTES (errado):**
```php
$services = Service::where('professional_id', auth()->user()->professional->id)->get();
```

**✅ AGORA (correto):**
```php
$services = Service::all(); // O trait BelongsToTenant filtra automaticamente
```

### 4. Páginas Públicas (sem Tenancy)

Para páginas públicas (booking, bio), defina o tenant manualmente:

```php
public function show($slug)
{
    $professional = Professional::where('slug', $slug)->firstOrFail();
    
    // Define o tenant para esta requisição
    Tenancy::setTenantId($professional->id);
    
    // Agora todas as queries filtram pelo professional_id correto
    $services = Service::all(); // Serviços deste professional
    $employees = Employee::all(); // Funcionários deste professional
    
    return view('public.show', compact('professional', 'services', 'employees'));
}
```

## 📝 Models com Tenancy

Models que usam `BelongsToTenant`:
- ✅ Service
- ✅ Employee
- ✅ Customer
- ✅ Appointment
- ✅ Availability
- ✅ Event
- ✅ Gallery
- ✅ PaymentMethod
- ✅ TransactionCategory
- ✅ FinancialTransaction
- ✅ Commission
- (e outros)

Models **SEM** tenancy:
- ❌ User
- ❌ Professional

## 🎯 Fluxo de Acesso

### Usuário Comum (role: usuario)
1. Faz login
2. Middleware `SetTenantFromAuth` define `Tenancy::setTenantId($user->professional->id)`
3. Acessa painel (`/painel/*`)
4. Vê apenas **seus próprios** dados (serviços, funcionários, clientes, etc.)

### Admin (role: admin)
1. Faz login
2. Middleware define tenant (se tiver professional)
3. Acessa áreas administrativas (`/admin/*`)
4. Pode ter lógica especial para ver múltiplos tenants (se necessário)

### Público (não autenticado)
1. Acessa página pública (`/{slug}`)
2. Controller define `Tenancy::setTenantId($professional->id)` manualmente
3. Vê dados públicos daquele professional específico

## 🚀 Exemplo Prático

### Cadastro de Novo Usuário

```php
// Criar usuário
$user = User::create([
    'name' => 'João Silva',
    'email' => 'joao@example.com',
    'password' => bcrypt('senha'),
    'role' => 'usuario', // Padrão
    'plan' => 'free',
]);

// Criar professional associado
$professional = Professional::create([
    'user_id' => $user->id,
    'name' => 'Salão do João',
    'slug' => 'salao-do-joao',
    'email' => 'contato@salaojoao.com',
]);
```

### Criar Serviço (automaticamente vinculado ao tenant)

```php
// Controller
public function store(Request $request)
{
    // Não precisa passar professional_id - o trait adiciona automaticamente
    $service = Service::create([
        'name' => $request->name,
        'duration' => $request->duration,
        'price' => $request->price,
    ]);
    // $service->professional_id será = auth()->user()->professional->id
}
```

## 🔍 Debugging

Para verificar qual tenant está ativo:

```php
use App\Support\Tenancy;

// Em qualquer lugar do código
$tenantId = Tenancy::tenantId();
dd($tenantId); // Mostra o professional_id atual
```

## ⚠️ Importante

1. **Sempre** use o trait `BelongsToTenant` em models que dependem de `professional_id`
2. **Nunca** filtre manualmente por `professional_id` em controllers do painel
3. Para páginas públicas, **sempre** defina o tenant com `Tenancy::setTenantId()`
4. Novos usuários devem sempre ter uma role (`usuario` por padrão)
5. Todo usuário deve ter um `professional` associado para o tenancy funcionar

## 📚 Referências

- Middleware: `app/Http/Middleware/SetTenantFromAuth.php`
- Trait Tenancy: `app/Models/Concerns/BelongsToTenant.php`
- Tenancy Service: `app/Support/Tenancy.php`
- User Model: `app/Models/User.php`
- CheckRole Middleware: `app/Http/Middleware/CheckRole.php`

