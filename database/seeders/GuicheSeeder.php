<?php

namespace Database\Seeders;

use App\Models\Guiche;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class GuicheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('guiches')->insert([
            [
                'id' => 1,
                'ip' => '192.168.0.134',
                'localizacao' => 'SSIP / 12',
                'nome_ref' => '1 A',
                'panel_id' => 1,
                'cor' => '#000FFF'
            ],
            [
                'id' => 2,
                'ip' => '192.168.0.156',
                'localizacao' => 'Comando Operacional',
                'nome_ref' => '3 B',
                'panel_id' => 1,
                'cor' => '#000000'
            ]
        ]);
    }
}
