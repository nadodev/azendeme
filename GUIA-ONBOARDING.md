# 🎯 Sistema de Onboarding - Tour Guiado

## 📋 Visão Geral

O sistema de onboarding é um tour interativo que guia novos usuários pelo painel administrativo, mostrando as principais funcionalidades e a ordem recomendada de configuração.

## ✨ Características

- ✅ Tour automático na primeira vez que o usuário acessa o painel
- ✅ Destaque visual nos elementos importantes
- ✅ Passos sequenciais com explicações claras
- ✅ Possibilidade de pular ou pausar o tour
- ✅ Registro do progresso do usuário
- ✅ Opção de reiniciar o tour a qualquer momento

## 🚀 Como Funciona

### 1. Primeira Vez no Painel

Quando um **novo usuário** faz login pela primeira vez:

1. O tour inicia automaticamente após 500ms
2. Uma caixa de diálogo aparece destacando o **Dashboard**
3. O usuário pode:
   - Clicar em **"Próximo →"** para continuar
   - Clicar em **"Pular"** para fechar o tour
   - Clicar em **"← Anterior"** para voltar (exceto no primeiro passo)

### 2. Sequência do Tour

O tour guia o usuário por **7 passos**:

#### Passo 1: Dashboard
- **Elemento:** Link do Dashboard na sidebar
- **Mensagem:** Boas-vindas e introdução ao painel

#### Passo 2: Serviços
- **Elemento:** Menu "Serviços"
- **Mensagem:** Explica como cadastrar serviços (nome, duração, preço)

#### Passo 3: Funcionários
- **Elemento:** Menu "Funcionários"  
- **Mensagem:** Como cadastrar colaboradores e atribuir serviços

#### Passo 4: Disponibilidade
- **Elemento:** Menu "Disponibilidade"
- **Mensagem:** Configurar horários de atendimento

#### Passo 5: Agendamentos
- **Elemento:** Menu "Agendamentos"
- **Mensagem:** Como visualizar e gerenciar agendamentos

#### Passo 6: Perfil Público
- **Elemento:** Menu "Configurações → Gerais"
- **Mensagem:** Personalizar página pública

#### Passo 7: Conclusão
- **Mensagem:** Lista de próximos passos recomendados
- **Dica:** Como acessar o tour novamente

## 💾 Banco de Dados

### Tabela: `users`

Campos adicionados:

```sql
onboarding_completed BOOLEAN DEFAULT false
onboarding_steps JSON NULL
```

- **`onboarding_completed`**: Indica se o usuário completou o tour
- **`onboarding_steps`**: Array JSON com os passos já concluídos

### Exemplo de Dados

```json
{
  "onboarding_completed": false,
  "onboarding_steps": ["dashboard", "services", "employees"]
}
```

## 🔧 Arquivos do Sistema

### 1. Migração
```
database/migrations/2025_10_16_163750_add_onboarding_completed_to_users_table.php
```

### 2. Controller
```
app/Http/Controllers/Panel/OnboardingController.php
```

**Endpoints:**
- `POST /panel/onboarding/complete` - Marca tour como completo
- `POST /panel/onboarding/skip` - Pula o tour
- `POST /panel/onboarding/reset` - Reinicia o tour
- `POST /panel/onboarding/step` - Marca um passo como completo

### 3. Componente Blade
```
resources/views/components/onboarding-tour.blade.php
```

### 4. Layout do Painel
```
resources/views/panel/layout.blade.php
```

**IDs adicionados:**
- `#dashboard-link`
- `#services-menu`
- `#employees-menu`
- `#availability-menu`
- `#appointments-menu`
- `#profile-menu`

## 📚 Biblioteca Utilizada

**Driver.js v1.3.1**  
https://driverjs.com/

- CDN CSS: `https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css`
- CDN JS: `https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js`

## 🎨 Personalização

### Textos e Mensagens

Edite `resources/views/components/onboarding-tour.blade.php`:

```javascript
steps: [
    {
        element: '#dashboard-link',
        popover: {
            title: '👋 Seu Título Aqui',
            description: 'Sua descrição aqui...',
            side: "bottom", // top, right, bottom, left
            align: 'start'  // start, center, end
        }
    }
]
```

### Cores e Estilos

No mesmo arquivo, seção `<style>`:

```css
.driver-popover-next-btn {
    background: var(--brand, #3b82f6) !important;
    /* Altere a cor aqui */
}
```

### Adicionar Novo Passo

1. Adicione um ID no elemento HTML:
```html
<a href="..." id="novo-elemento">Texto</a>
```

2. Adicione o passo no array `steps`:
```javascript
{
    element: '#novo-elemento',
    popover: {
        title: 'Título do Novo Passo',
        description: 'Descrição...',
        side: "right",
        align: 'start'
    }
}
```

## 🔄 Como Reiniciar o Tour

### Para o Usuário

**Opção 1:** Adicionar botão nas configurações

1. Ir em **Configurações**
2. Adicionar botão "Reiniciar Tour"
3. Ao clicar, chama `POST /panel/onboarding/reset`

### Para o Desenvolvedor

**Via Tinker:**
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->onboarding_completed = false;
>>> $user->onboarding_steps = [];
>>> $user->save();
```

**Via SQL:**
```sql
UPDATE users 
SET onboarding_completed = 0, 
    onboarding_steps = NULL 
WHERE id = 1;
```

## 🧪 Testar o Onboarding

### 1. Criar Usuário de Teste

```bash
php artisan tinker
>>> User::create([
    'name' => 'Teste Onboarding',
    'email' => 'teste@onboarding.com',
    'password' => bcrypt('senha123'),
    'role' => 'usuario',
    'onboarding_completed' => false
]);
```

### 2. Fazer Login

1. Acesse: `http://localhost:8000/login`
2. Email: `teste@onboarding.com`
3. Senha: `senha123`
4. O tour deve iniciar automaticamente

### 3. Verificar no Console do Navegador

Abra DevTools (F12) → Console:
- Deve aparecer logs quando o tour inicia
- Ao completar: `"Onboarding concluído!"`
- Ao pular: `"Onboarding pulado"`

## 🚨 Troubleshooting

### Tour não inicia

**Verificar:**
1. Usuário está autenticado?
   ```blade
   @if(auth()->check())
   ```

2. `onboarding_completed` está `false`?
   ```bash
   php artisan tinker
   >>> User::find(1)->onboarding_completed
   ```

3. Elementos existem na página?
   - Abra DevTools → Elements
   - Procure por `id="dashboard-link"`

4. Driver.js carregou?
   - DevTools → Console
   - Digite: `window.driver`
   - Deve retornar objeto, não `undefined`

### Erro: "driver is not a function"

**Solução:** Driver.js não carregou do CDN

1. Verifique conexão com internet
2. Ou baixe localmente:
```bash
npm install driver.js
```

Depois importe no layout:
```blade
<link rel="stylesheet" href="{{ asset('node_modules/driver.js/dist/driver.css') }}">
<script src="{{ asset('node_modules/driver.js/dist/driver.js.iife.js') }}"></script>
```

### Tour aparece mas elementos não destacam

**Solução:** IDs estão incorretos ou elementos não existem

1. Inspecione o elemento que deveria destacar
2. Confirme que o ID está correto
3. Verifique se há CSS `z-index` muito alto bloqueando

### Erro: "Undefined constant current/total"

**Solução:** Blade está processando as chaves `{{current}}`

Use `@` para escapar:
```javascript
progressText: 'Passo @{{current}} de @{{total}}'
```

## 📊 Métricas e Analytics

### Rastrear Progresso dos Usuários

```sql
-- Usuários que completaram o onboarding
SELECT COUNT(*) FROM users WHERE onboarding_completed = 1;

-- Usuários que pularam
SELECT COUNT(*) FROM users 
WHERE onboarding_completed = 1 
AND onboarding_steps IS NULL;

-- Média de passos completados antes de pular
SELECT AVG(JSON_LENGTH(onboarding_steps)) 
FROM users 
WHERE onboarding_completed = 0 
AND onboarding_steps IS NOT NULL;
```

### Adicionar Tracking (Opcional)

No `OnboardingController.php`:

```php
use Illuminate\Support\Facades\Log;

public function completeStep(Request $request)
{
    $step = $request->step;
    
    // Log para analytics
    Log::channel('analytics')->info('Onboarding step completed', [
        'user_id' => auth()->id(),
        'step' => $step,
        'timestamp' => now()
    ]);
    
    // ... resto do código
}
```

## 🎯 Próximos Passos Recomendados

Após implementar o onboarding básico, considere:

1. **Adicionar passos condicionais**
   - Mostrar passos diferentes baseados no plano do usuário
   - Ex: "Premium features" apenas para planos pagos

2. **Criar mini-tours específicos**
   - Tour para nova funcionalidade lançada
   - Tour para área específica (ex: só para o Financeiro)

3. **Adicionar vídeos explicativos**
   - Integrar vídeos do YouTube nos popovers
   - Tutoriais em vídeo para cada passo

4. **Gamificação**
   - Dar badges ao completar o tour
   - Sistema de pontos por configurações concluídas

5. **Feedback do usuário**
   - Botão "Isso foi útil?" em cada passo
   - Coletar sugestões de melhoria

## 📝 Checklist de Implementação

- [x] Criar migração para campos de onboarding
- [x] Atualizar Model User com fillable e casts
- [x] Criar OnboardingController
- [x] Adicionar rotas de onboarding
- [x] Criar componente Blade do tour
- [x] Adicionar IDs nos elementos do menu
- [x] Incluir componente no layout do painel
- [x] Testar tour com usuário novo
- [ ] Adicionar botão "Reiniciar Tour" nas configurações
- [ ] Criar analytics para rastrear conclusão
- [ ] Documentar para equipe

## 🔗 Links Úteis

- Driver.js Docs: https://driverjs.com/docs/
- Exemplos: https://driverjs.com/examples/
- GitHub: https://github.com/kamranahmedse/driver.js

---

✅ **Sistema de Onboarding implementado com sucesso!**

Agora seus usuários terão um tour guiado na primeira vez que acessarem o painel, facilitando a configuração inicial e reduzindo dúvidas.

