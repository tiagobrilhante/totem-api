<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImasgemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('imagems')->insert([
                [
                    'id'=>1,
                    'nome' => 'Foto 1',
                    'ordem' => 1,
                    'imagem'=>'imagens/1/1.jpg',
                    'legenda'=> 'Legenda Sobre a foto',
                    'banner'=> 1,
                    'assunto_id'=>1
                ],
                [
                    'id'=>2,
                    'nome' => 'Foto 2',
                    'ordem' => 2,
                    'imagem'=>'imagens/1/2.jpg',
                    'legenda'=> '',
                    'banner'=> 0,
                    'assunto_id'=>1
                ],
                [
                    'id'=>3,
                    'nome' => 'Foto outro 1',
                    'ordem' => 1,
                    'imagem'=>'imagens/2/1.jpg',
                    'legenda'=> 'Legenda Sobre a foto tal',
                    'banner'=> 1,
                    'assunto_id'=>2
                ],
                [
                    'id'=>4,
                    'nome' => 'Foto outro 2',
                    'ordem' => 2,
                    'imagem'=>'imagens/2/2.jpg',
                    'legenda'=> 'Legenda Sobre a foto tal 2',
                    'banner'=> 0,
                    'assunto_id'=>2
                ],
                [
                    'id'=>5,
                    'nome' => '',
                    'ordem' => 1,
                    'imagem'=>'imagens/3/1.jpg',
                    'legenda'=> '',
                    'banner'=> 1,
                    'assunto_id'=>3
                ],
                [
                    'id'=>6,
                    'nome' => 'teste',
                    'ordem' => 2,
                    'imagem'=>'imagens/3/2.jpg',
                    'legenda'=> 'teste de legenda',
                    'banner'=> 0,
                    'assunto_id'=>3
                ],
                [
                    'id'=>7,
                    'nome' => 'Uma imagem',
                    'ordem' => 1,
                    'imagem'=>'imagens/4/1.jpg',
                    'legenda'=> 'mais uma legenda',
                    'banner'=> 1,
                    'assunto_id'=>4
                ],
                [
                    'id'=>8,
                    'nome' => 'Uma imagem Nova',
                    'ordem' => 2,
                    'imagem'=>'imagens/4/2.jpg',
                    'legenda'=> '',
                    'banner'=> 0,
                    'assunto_id'=>4
                ],
                [
                    'id'=>9,
                    'nome' => '',
                    'ordem' => 1,
                    'imagem'=>'imagens/5/1.jpg',
                    'legenda'=> 'Legenda optativa',
                    'banner'=> 1,
                    'assunto_id'=>5
                ],
                [
                    'id'=>10,
                    'nome' => '',
                    'ordem' => 2,
                    'imagem'=>'imagens/5/2.jpg',
                    'legenda'=> '',
                    'banner'=> 0,
                    'assunto_id'=>5
                ],
                [
                    'id'=>11,
                    'nome' => 'Coisas em Imagens',
                    'ordem' => 1,
                    'imagem'=>'imagens/6/1.jpg',
                    'legenda'=> 'legenda em texto',
                    'banner'=> 1,
                    'assunto_id'=>6
                ],
                [
                    'id'=>12,
                    'nome' => 'Coisas aleatórias',
                    'ordem' => 2,
                    'imagem'=>'imagens/6/2.jpg',
                    'legenda'=> 'legenda explicativas',
                    'banner'=> 0,
                    'assunto_id'=>6
                ],
                [
                    'id'=>13,
                    'nome' => '',
                    'ordem' => 1,
                    'imagem'=>'imagens/7/1.jpg',
                    'legenda'=> '',
                    'banner'=> 1,
                    'assunto_id'=>7
                ],
                [
                    'id'=>14,
                    'nome' => 'nome importante',
                    'ordem' => 2,
                    'imagem'=>'imagens/7/2.jpg',
                    'legenda'=> 'legenda importante',
                    'banner'=> 0,
                    'assunto_id'=>7
                ],
                [
                    'id'=>15,
                    'nome' => 'um nome qualquer',
                    'ordem' => 1,
                    'imagem'=>'imagens/8/1.jpg',
                    'legenda'=> 'legenda qualquer',
                    'banner'=> 1,
                    'assunto_id'=>8
                ],
                [
                    'id'=>16,
                    'nome' => '',
                    'ordem' => 2,
                    'imagem'=>'imagens/8/2.jpg',
                    'legenda'=> '',
                    'banner'=> 0,
                    'assunto_id'=>8
                ],





            ]
        );
    }
}
