<?php

namespace Database\Seeders;

use App\Models\Chamada;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ChamadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chamadas')->insert([
            [
                'id' => 1,
                'tipo'=>'Normal',
                'tipo_atendimento'=>'Prova de Vida',
                'publico_alvo'=>'Veterano',
                'publico_alvo_id'=>1,
                'guiche_id'=>1,
                'numero_ref'=>1,
                'nome_ref'=> null,
                'panel_id' => 1,
                'status'=>'OK',
                'chamador'=>'Cel Outro',
                'rechamada'=>false,
                'created_at'=> '2021-02-01 12:00:00'


            ],
            [
                'id' => 2,
                'tipo'=>'Normal',
                'tipo_atendimento'=>'Prova de Vida',
                'publico_alvo'=>'Veterano',
                'publico_alvo_id'=>1,
                'guiche_id'=>1,
                'numero_ref'=>9,
                'nome_ref'=> null,
                'panel_id' => 1,
                'status'=>'OK',
                'chamador'=>'Cel Outro',
                'rechamada'=>false,
                'created_at'=>'2021-02-13 13:00:01'

            ],
            [
                'id' => 3,
                'tipo'=>'Preferencial',
                'tipo_atendimento'=>'Prova de Vida',
                'publico_alvo'=>'Veterano',
                'publico_alvo_id'=>1,
                'guiche_id'=>1,
                'numero_ref'=>6,
                'nome_ref'=> null,
                'panel_id' => 1,
                'status'=>'OK',
                'chamador'=>'Cel Outro',
                'rechamada'=>false,
                'created_at'=>'2021-01-01 10:00:01'

            ],

        ]);
    }
}

