<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('Nenhum usuário encontrado. Execute o UserSeeder primeiro.');
            return;
        }

        $recipes = [
            [
                'title' => 'Bolo de Chocolate Fofinho',
                'description' => 'Um delicioso bolo de chocolate super fofinho e molhadinho, perfeito para o café da tarde.',
                'ingredients' => [
                    '3 ovos',
                    '2 xícaras de açúcar',
                    '2 xícaras de farinha de trigo',
                    '1 xícara de chocolate em pó',
                    '1 xícara de água quente',
                    '1/2 xícara de óleo',
                    '1 colher de sopa de fermento em pó',
                ],
                'steps' => "1. Preaqueça o forno a 180°C e unte uma forma.\n2. Bata os ovos com o açúcar até ficar cremoso.\n3. Adicione o óleo e misture bem.\n4. Acrescente a farinha, o chocolate em pó e misture.\n5. Por último, adicione a água quente e o fermento, mexendo delicadamente.\n6. Despeje na forma e leve ao forno por 40 minutos.",
            ],
            [
                'title' => 'Lasanha à Bolonhesa',
                'description' => 'Uma lasanha clássica com molho bolonhesa caseiro e muito queijo.',
                'ingredients' => [
                    '500g de massa para lasanha',
                    '500g de carne moída',
                    '1 cebola picada',
                    '2 dentes de alho',
                    '500ml de molho de tomate',
                    '500g de queijo mussarela',
                    '200g de presunto',
                    '2 colheres de sopa de manteiga',
                    '2 colheres de sopa de farinha de trigo',
                    '500ml de leite',
                    'Sal e pimenta a gosto',
                ],
                'steps' => "1. Refogue a cebola e o alho, adicione a carne moída e tempere.\n2. Acrescente o molho de tomate e deixe cozinhar por 20 minutos.\n3. Para o molho branco: derreta a manteiga, adicione a farinha e mexa bem.\n4. Adicione o leite aos poucos, mexendo até engrossar.\n5. Em um refratário, monte camadas: molho bolonhesa, massa, presunto, queijo, molho branco.\n6. Repita as camadas e finalize com queijo.\n7. Leve ao forno a 200°C por 30-40 minutos.",
            ],
            [
                'title' => 'Brigadeiro Gourmet',
                'description' => 'O clássico brasileiro em versão gourmet, com chocolate nobre.',
                'ingredients' => [
                    '1 lata de leite condensado',
                    '1 colher de sopa de manteiga',
                    '3 colheres de sopa de chocolate em pó 70%',
                    'Chocolate granulado para decorar',
                ],
                'steps' => "1. Em uma panela, misture o leite condensado, a manteiga e o chocolate em pó.\n2. Cozinhe em fogo médio, mexendo sempre, até desgrudar do fundo da panela.\n3. Despeje em um prato untado e deixe esfriar.\n4. Faça bolinhas com as mãos untadas de manteiga.\n5. Passe no chocolate granulado.\n6. Coloque em forminhas e sirva.",
            ],
            [
                'title' => 'Macarrão ao Alho e Óleo',
                'description' => 'Um prato simples, rápido e delicioso para qualquer ocasião.',
                'ingredients' => [
                    '500g de espaguete',
                    '6 dentes de alho fatiados',
                    '1/2 xícara de azeite de oliva',
                    'Pimenta calabresa a gosto',
                    'Salsinha picada',
                    'Sal a gosto',
                    'Queijo parmesão ralado',
                ],
                'steps' => "1. Cozinhe o macarrão em água fervente com sal até ficar al dente.\n2. Enquanto isso, aqueça o azeite em uma frigideira.\n3. Adicione o alho e doure levemente.\n4. Acrescente a pimenta calabresa.\n5. Escorra o macarrão e misture com o alho e óleo.\n6. Finalize com salsinha e queijo parmesão ralado.",
            ],
            [
                'title' => 'Salada Caesar',
                'description' => 'Uma refrescante salada com molho caesar cremoso e crocante.',
                'ingredients' => [
                    '1 pé de alface americana',
                    '200g de peito de frango grelhado',
                    '100g de queijo parmesão',
                    'Croutons',
                    '2 colheres de sopa de maionese',
                    '1 colher de sopa de mostarda dijon',
                    'suco de 1/2 limão',
                    '2 dentes de alho',
                    'Azeite de oliva',
                ],
                'steps' => "1. Lave e corte a alface em pedaços.\n2. Grelhe o peito de frango e corte em tiras.\n3. Para o molho: bata no liquidificador a maionese, mostarda, alho, limão e azeite.\n4. Em uma tigela, misture a alface, o frango e o molho.\n5. Finalize com parmesão ralado e croutons.",
            ],
            [
                'title' => 'Torta de Limão',
                'description' => 'Uma sobremesa refrescante com base crocante e recheio cremoso de limão.',
                'ingredients' => [
                    '200g de biscoito maisena triturado',
                    '100g de manteiga derretida',
                    '1 lata de leite condensado',
                    '1/2 xícara de suco de limão',
                    '3 claras',
                    '3 colheres de sopa de açúcar',
                ],
                'steps' => "1. Misture o biscoito triturado com a manteiga e forre uma forma.\n2. Leve à geladeira por 15 minutos.\n3. Misture o leite condensado com o suco de limão até engrossar.\n4. Despeje sobre a base e reserve.\n5. Bata as claras em neve, adicione o açúcar aos poucos.\n6. Cubra a torta com o merengue.\n7. Leve ao forno para dourar levemente e sirva gelada.",
            ],
        ];

        foreach ($recipes as $index => $recipeData) {
            $user = $users[$index % $users->count()];
            
            Recipe::create([
                'user_id' => $user->id,
                'title' => $recipeData['title'],
                'description' => $recipeData['description'],
                'ingredients' => $recipeData['ingredients'],
                'steps' => $recipeData['steps'],
            ]);
        }
    }
}
