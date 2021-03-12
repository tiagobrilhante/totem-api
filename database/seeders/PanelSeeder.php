<?php

namespace Database\Seeders;

use App\Models\Panel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('panels')->insert([
            [
                'id' => 1,
                'ip' => '192.168.0.20',
                'localizacao' => 'SSIP / 12',
                'om_id' => 1,
                'cor' => '#000FFF'
            ],
            [
                'id' => 2,
                'ip' => '192.168.0.21',
                'localizacao' => 'Comando Operacional',
                'om_id' => 2,
                'cor' => '#000000'
            ]
        ]);
    }
}
