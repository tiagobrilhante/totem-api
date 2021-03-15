<?php

namespace Database\Seeders;

use App\Models\Guiche;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ChamadaPrioridadeParametroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chamada_prioridade_parametros')->insert([
            [
                'id' => 1,
                'numero_inicial' => 7,
                'data_ref' => '2021-01-01',
                'responsavel' => 'Maj Brilhante',
                'om_id'=>1
            ]
        ]);
    }
}
