<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssuntosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('assuntos')->insert([
                [
                    'id'=>1,
                    'nome_assunto' => 'Batalhas Históricas',
                    'ordem_exibicao' => 1

                ],
                [
                    'id'=>2,
                    'nome_assunto' => 'Curiosidades sobre a Amazônia',
                    'ordem_exibicao' => 2

                ],
                [
                    'id'=>3,
                    'nome_assunto' => 'Personagens Ilustres',
                    'ordem_exibicao' => 3

                ],
                [
                    'id'=>4,
                    'nome_assunto' => 'A evolução do Armamento',
                    'ordem_exibicao' => 4

                ],
                [
                    'id'=>5,
                    'nome_assunto' => 'Fatores Políticos',
                    'ordem_exibicao' => 5

                ],
                [
                    'id'=>6,
                    'nome_assunto' => 'Fatores Geográficos',
                    'ordem_exibicao' => 6

                ],
                [
                    'id'=>7,
                    'nome_assunto' => 'O Brasil Colônia',
                    'ordem_exibicao' => 7

                ],
                [
                    'id'=>8,
                    'nome_assunto' => 'O Exército Moderno',
                    'ordem_exibicao' => 8

                ],
            ]
        );
    }
}
