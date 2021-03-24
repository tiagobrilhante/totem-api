<?php

namespace Database\Seeders;

use App\Models\Guiche;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ChamadaNormalParametroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chamada_normal_parametros')->insert([
            [
                'id' => 1,
                'numero_inicial' => 1,
                'data_ref' => '2021-02-01',
                'responsavel' => 'Maj Brilhante',
                'validacao' => 'Ok',
                'panel_id'=>1
            ],
            [
                'id' => 2,
                'numero_inicial' => 10,
                'data_ref' => '2021-02-13',
                'responsavel' => 'Maj Brilhante',
                'validacao' => 'Ok',
                'panel_id'=>2
            ]
        ]);
    }
}
