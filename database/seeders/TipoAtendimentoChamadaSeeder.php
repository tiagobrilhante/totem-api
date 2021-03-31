<?php

namespace Database\Seeders;

use App\Models\Chamada;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TipoAtendimentoChamadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chamada_tipo_atendimentos')->insert([
            [
                'id' => 1,
                'tipo_atendimento_id'=>1,
                'chamada_id'=>1

            ],
            [
                'id' => 2,
                'tipo_atendimento_id'=>1,
                'chamada_id'=>2

            ],
            [
                'id' => 3,
                'tipo_atendimento_id'=>1,
                'chamada_id'=>3

            ],

        ]);
    }
}

