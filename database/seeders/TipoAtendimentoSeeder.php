<?php

namespace Database\Seeders;

use App\Models\Panel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TipoAtendimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_atendimentos')->insert([
            [
                'id' => 1,
                'tipo' => 'Prova de Vida',
                'om_id' => 1,
                'cor' => '#000FFF'
            ],
            [
                'id' => 2,
                'tipo' => 'Pensão por Invalidez',
                'om_id' => 2,
                'cor' => '#000000'
            ],
            [
                'id' => 3,
                'tipo' => 'Cota Parte',
                'om_id' => 1,
                'cor' => '#CCC000'
            ]
        ]);
    }
}
