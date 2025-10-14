<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Professional;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run()
    {
        // Buscar o primeiro profissional
        $professional = Professional::first();
        
        if (!$professional) {
            $this->command->info('Nenhum profissional encontrado. Execute primeiro o ProfessionalSeeder.');
            return;
        }

        // Buscar categorias
        $categories = BlogCategory::where('professional_id', $professional->id)->get();
        $tags = BlogTag::where('professional_id', $professional->id)->get();

        if ($categories->isEmpty() || $tags->isEmpty()) {
            $this->command->info('Categorias ou tags não encontradas. Execute primeiro os seeders de categorias e tags.');
            return;
        }

        $posts = [
            [
                'title' => 'Dicas Essenciais para Cuidados com a Pele',
                'slug' => 'dicas-essenciais-cuidados-pele',
                'excerpt' => 'Descubra as melhores práticas para manter sua pele saudável e radiante todos os dias.',
                'content' => '<p>O cuidado com a pele é fundamental para manter uma aparência saudável e jovem. Neste post, vamos explorar as melhores práticas e produtos recomendados para diferentes tipos de pele.</p><p>É importante entender que cada tipo de pele tem necessidades específicas. Peles oleosas precisam de produtos que controlem a produção de sebo, enquanto peles secas necessitam de hidratação intensa.</p><p>Lembre-se sempre de consultar um profissional qualificado para obter orientações personalizadas.</p>',
                'featured' => true,
                'status' => 'published',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Tendências de Cabelo para 2024',
                'slug' => 'tendencias-cabelo-2024',
                'excerpt' => 'As principais tendências de cortes e cores que estarão em alta este ano.',
                'content' => '<p>O ano de 2024 traz muitas novidades no mundo da beleza capilar. Cortes assimétricos, cores vibrantes e técnicas inovadoras estão dominando as passarelas e as redes sociais.</p><p>Entre as tendências mais destacadas estão o wolf cut, o mullet moderno e as mechas coloridas em tons pastel. Esses estilos oferecem personalidade e modernidade.</p><p>É importante escolher um estilo que combine com seu rosto e estilo de vida. Consulte sempre um profissional qualificado.</p>',
                'featured' => true,
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Como Escolher o Corte Ideal para Seu Rosto',
                'slug' => 'como-escolher-corte-ideal-rosto',
                'excerpt' => 'Guia completo para encontrar o corte de cabelo perfeito para o formato do seu rosto.',
                'content' => '<p>Escolher o corte de cabelo ideal é uma decisão importante que pode realçar seus traços naturais. O formato do rosto é o fator mais importante a considerar.</p><p>Para rostos redondos, cortes com volume no topo e laterais mais estreitas criam a ilusão de alongamento. Rostos quadrados se beneficiam de cortes com camadas suaves que suavizam os ângulos.</p><p>Rostos ovais são os mais versáteis e podem usar praticamente qualquer estilo. Já rostos alongados ficam melhores com cortes que adicionam volume nas laterais.</p>',
                'featured' => false,
                'status' => 'published',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Produtos de Beleza Essenciais para o Dia a Dia',
                'slug' => 'produtos-beleza-essenciais-dia-dia',
                'excerpt' => 'Lista dos produtos indispensáveis para uma rotina de beleza eficaz e prática.',
                'content' => '<p>Uma rotina de beleza eficaz não precisa ser complicada. Com os produtos certos, você pode manter sua pele e cabelo saudáveis com poucos passos.</p><p>Os produtos essenciais incluem: limpador facial, hidratante, protetor solar, shampoo e condicionador adequados ao seu tipo de cabelo, e um produto para tratamento específico.</p><p>Lembre-se de que a qualidade é mais importante que a quantidade. Invista em produtos de boa qualidade que atendam às suas necessidades específicas.</p>',
                'featured' => true,
                'status' => 'published',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Cuidados com o Cabelo no Verão',
                'slug' => 'cuidados-cabelo-verao',
                'excerpt' => 'Como proteger e cuidar do seu cabelo durante os meses mais quentes do ano.',
                'content' => '<p>O verão pode ser um período desafiador para a saúde do cabelo. O sol, o cloro da piscina e o sal do mar podem causar danos significativos.</p><p>Para proteger seu cabelo, use sempre produtos com proteção UV, evite exposição prolongada ao sol e lave o cabelo após nadar em piscinas ou no mar.</p><p>Hidratação é fundamental. Use máscaras capilares semanalmente e considere tratamentos profissionais para restaurar a saúde dos fios.</p>',
                'featured' => false,
                'status' => 'published',
                'published_at' => now()->subDays(12),
            ],
        ];

        foreach ($posts as $postData) {
            $post = BlogPost::create([
                'professional_id' => $professional->id,
                'category_id' => $categories->random()->id,
                'title' => $postData['title'],
                'slug' => $postData['slug'],
                'excerpt' => $postData['excerpt'],
                'content' => $postData['content'],
                'featured' => $postData['featured'],
                'status' => $postData['status'],
                'published_at' => $postData['published_at'],
                'allow_comments' => true,
            ]);

            // Adicionar tags aleatórias
            $randomTags = $tags->random(rand(1, 3));
            $post->tags()->attach($randomTags->pluck('id'));
        }

        $this->command->info('Posts de blog criados com sucesso!');
        $this->command->info('Posts em destaque: ' . BlogPost::where('featured', true)->count());
    }
}