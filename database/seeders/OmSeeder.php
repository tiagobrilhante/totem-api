<?php

namespace Database\Seeders;

use App\Models\Om;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class OmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oms')->insert([
            [
                'id' => 1,
                'nome' => '12 Região Militar',
                'sigla' => '12 RM',
                'cor' => '#000FFF'
            ],
            [
                'id' => 2,
                'nome' => 'Comando Militar da Amazônia',
                'sigla' => 'CMA',
                'cor' => '#000000'
            ]
        ]);
    }
}
