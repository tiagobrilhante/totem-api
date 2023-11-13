<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('eventos')->insert([
                [
                    'id'=>1,
                    'dia' => 12,
                    'mes' => 11,
                    'ano' => 1560,
                    'nome'=> 'tomada de monte castelo',
                    'imagem'=> null,
                    'legenda'=> 'Legenda sobre o evento',
                ],
                [
                    'id'=>2,
                    'dia' => 9,
                    'mes' => 2,
                    'ano' => 1400,
                    'nome'=> 'teste de algo',
                    'imagem'=> null,
                    'legenda'=> 'Legenda sobre o evento de teste',
                ],
                [
                    'id'=>3,
                    'dia' => 23,
                    'mes' => 5,
                    'ano' => 1780,
                    'nome'=> 'Assinatura de algo',
                    'imagem'=> null,
                    'legenda'=> 'Legenda sobre o evento novo',
                ],

            ]
        );
    }
}
