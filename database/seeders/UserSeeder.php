<?php

namespace Database\Seeders;

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
                    'email' => 'tiagobrilhantemania@gmail.com',
                    'nome' => 'Tiago da Silva Brilhante',
                    'password' => Hash::make('123456')

                ],
                [
                    'email' => 'teste@gmail.com',
                    'nome' => 'Teste de Teste',
                    'password' => Hash::make('123456')

                ]
            ]
        );
    }
}
