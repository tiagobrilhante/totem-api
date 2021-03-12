<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                [
                    'cpf' => '512.490.302-34',
                    'nome' => 'Teste de usuario',
                    'nome_guerra' => 'Teste',
                    'posto_grad' => 'Maj',
                    'om_id' => 1,
                    'tipo' => 'Administrador Geral',
                    'password' => Hash::make('123456'),
                    'reset' => 0

                ],
                [
                    'cpf' => '518.656.580-65',
                    'nome' => 'outro teste de usuario',
                    'nome_guerra' => 'Outro',
                    'posto_grad' => 'Cel',
                    'om_id' => 1,
                    'tipo' => 'Chamador',
                    'password' => Hash::make('123456'),
                    'reset' => 0

                ],
                [
                    'cpf' => '826.304.610-68',
                    'nome' => 'Amigo da onça',
                    'nome_guerra' => 'Onça',
                    'posto_grad' => 'Cap',
                    'om_id' => 2,
                    'tipo' => 'Administrador',
                    'password' => Hash::make('123456'),
                    'reset' => 0

                ]
            ]
        );
    }
}
