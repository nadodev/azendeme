<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\BlogPost;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professionalId = 1;

        // Criar categorias
        $categoriaGestao = BlogCategory::create([
            'professional_id' => $professionalId,
            'name' => 'Gestão de Agendamentos',
            'slug' => 'gestao-agendamentos',
            'description' => 'Dicas e estratégias para melhorar a gestão de agendamentos',
            'color' => '#3B82F6',
            'active' => true,
            'sort_order' => 1,
        ]);

        $categoriaMarketing = BlogCategory::create([
            'professional_id' => $professionalId,
            'name' => 'Marketing Digital',
            'slug' => 'marketing-digital',
            'description' => 'Estratégias de marketing para profissionais autônomos',
            'color' => '#10B981',
            'active' => true,
            'sort_order' => 2,
        ]);

        $categoriaAtendimento = BlogCategory::create([
            'professional_id' => $professionalId,
            'name' => 'Atendimento ao Cliente',
            'slug' => 'atendimento-cliente',
            'description' => 'Como melhorar o atendimento e satisfação dos clientes',
            'color' => '#F59E0B',
            'active' => true,
            'sort_order' => 3,
        ]);

        // Criar tags
        $tagAgendamento = BlogTag::create([
            'professional_id' => $professionalId,
            'name' => 'Agendamento Online',
            'slug' => 'agendamento-online',
            'color' => '#8B5CF6',
            'active' => true,
        ]);

        $tagProdutividade = BlogTag::create([
            'professional_id' => $professionalId,
            'name' => 'Produtividade',
            'slug' => 'produtividade',
            'color' => '#EF4444',
            'active' => true,
        ]);

        $tagRedesSociais = BlogTag::create([
            'professional_id' => $professionalId,
            'name' => 'Redes Sociais',
            'slug' => 'redes-sociais',
            'color' => '#06B6D4',
            'active' => true,
        ]);

        $tagFidelizacao = BlogTag::create([
            'professional_id' => $professionalId,
            'name' => 'Fidelização',
            'slug' => 'fidelizacao',
            'color' => '#84CC16',
            'active' => true,
        ]);

        // Criar posts
        $post1 = BlogPost::create([
            'professional_id' => $professionalId,
            'category_id' => $categoriaGestao->id,
            'title' => 'Como Organizar sua Agenda de Forma Eficiente',
            'slug' => 'como-organizar-agenda-eficiente',
            'excerpt' => 'Descubra as melhores práticas para organizar sua agenda profissional e aumentar sua produtividade.',
            'content' => 'Organizar uma agenda profissional pode ser um desafio, especialmente quando você tem muitos clientes e serviços diferentes. Aqui estão algumas dicas essenciais para manter sua agenda organizada e eficiente:

1. **Use um Sistema de Agendamento Online**
   - Automatize o processo de agendamento
   - Reduza conflitos de horários
   - Permita que clientes agendem 24/7

2. **Defina Horários de Funcionamento**
   - Estabeleça horários fixos de atendimento
   - Reserve tempo para preparação e limpeza
   - Inclua pausas entre atendimentos

3. **Categorize seus Serviços**
   - Agrupe serviços similares
   - Defina durações específicas para cada tipo
   - Considere o tempo de preparação

4. **Mantenha um Buffer de Tempo**
   - Reserve 15-30 minutos entre atendimentos
   - Permita tempo para imprevistos
   - Evite sobrecarga de agenda

5. **Use Lembretes Automáticos**
   - Envie confirmações por SMS ou email
   - Reduza faltas e atrasos
   - Melhore a experiência do cliente

Com essas práticas, você conseguirá manter uma agenda mais organizada e profissional.',
            'status' => 'published',
            'featured' => true,
            'allow_comments' => true,
            'published_at' => now()->subDays(2),
        ]);

        $post2 = BlogPost::create([
            'professional_id' => $professionalId,
            'category_id' => $categoriaMarketing->id,
            'title' => '5 Estratégias de Marketing para Profissionais Autônomos',
            'slug' => '5-estrategias-marketing-profissionais-autonomos',
            'excerpt' => 'Aprenda estratégias práticas de marketing digital para atrair mais clientes e crescer seu negócio.',
            'content' => 'O marketing digital é essencial para profissionais autônomos que querem crescer e atrair mais clientes. Aqui estão 5 estratégias eficazes:

1. **Presença nas Redes Sociais**
   - Instagram: Mostre seu trabalho com fotos e stories
   - Facebook: Crie uma página profissional
   - WhatsApp Business: Use para atendimento rápido

2. **Google Meu Negócio**
   - Cadastre seu negócio no Google
   - Peça avaliações dos clientes
   - Mantenha informações atualizadas

3. **Marketing de Conteúdo**
   - Crie um blog com dicas do seu ramo
   - Compartilhe conhecimento no Instagram
   - Faça lives educativas

4. **Programa de Fidelidade**
   - Ofereça descontos para clientes frequentes
   - Crie um sistema de pontos
   - Premie a indicação de novos clientes

5. **Parcerias Estratégicas**
   - Faça parcerias com outros profissionais
   - Indique e seja indicado
   - Participe de eventos da área

Lembre-se: o marketing é um investimento de longo prazo. Seja consistente e paciente com os resultados.',
            'status' => 'published',
            'featured' => false,
            'allow_comments' => true,
            'published_at' => now()->subDays(5),
        ]);

        $post3 = BlogPost::create([
            'professional_id' => $professionalId,
            'category_id' => $categoriaAtendimento->id,
            'title' => 'Como Criar uma Experiência Excepcional para seus Clientes',
            'slug' => 'experiencia-excepcional-clientes',
            'excerpt' => 'Descubra como transformar cada atendimento em uma experiência memorável que fará seus clientes voltarem.',
            'content' => 'A experiência do cliente é um dos fatores mais importantes para o sucesso de qualquer negócio. Aqui estão as principais práticas:

**Primeira Impressão**
- Ambiente limpo e organizado
- Atendimento caloroso e profissional
- Pontualidade nos horários

**Durante o Atendimento**
- Ouça ativamente as necessidades do cliente
- Explique cada procedimento
- Mantenha um diálogo agradável

**Após o Atendimento**
- Agradeça pela preferência
- Peça feedback sobre o serviço
- Ofereça dicas de cuidados

**Ferramentas que Ajudam**
- Sistema de agendamento online
- Lembretes automáticos
- Programa de fidelidade
- Canal de comunicação direta

**Métricas Importantes**
- Taxa de retorno dos clientes
- Avaliações e recomendações
- Número de indicações recebidas

Lembre-se: clientes satisfeitos são seus melhores embaixadores!',
            'status' => 'published',
            'featured' => false,
            'allow_comments' => true,
            'published_at' => now()->subWeek(),
        ]);

        // Associar tags aos posts
        $post1->tags()->attach([$tagAgendamento->id, $tagProdutividade->id]);
        $post2->tags()->attach([$tagRedesSociais->id, $tagProdutividade->id]);
        $post3->tags()->attach([$tagFidelizacao->id]);
    }
}