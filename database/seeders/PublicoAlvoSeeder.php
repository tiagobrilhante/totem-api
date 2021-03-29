<?php

namespace Database\Seeders;

use App\Models\Panel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PublicoAlvoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('publico_alvos')->insert([
            [
                'id' => 1,
                'tipo' => 'Veterano',
                'om_id' => 1,
                'cor' => '#000FFF'
            ],
            [
                'id' => 2,
                'tipo' => 'Servidor Civil Aposentado',
                'om_id' => 2,
                'cor' => '#000000'
            ],
            [
                'id' => 3,
                'tipo' => 'Pensionista Militar',
                'om_id' => 1,
                'cor' => '#CCC000'
            ]
        ]);
    }
}
