<?php

namespace Database\Seeders;

use App\Models\Panel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MensagemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mensagems')->insert([
            [
                'id' => 1,
                'mensagem' => 'Mensagem 1',
                'responsavel' => 'Maj Teste',
                'om_id' => 1
            ],
            [
                'id' => 2,
                'mensagem' => 'Mensagem 2',
                'responsavel' => 'Maj Teste',
                'om_id' => 1
            ],

        ]);
    }
}
