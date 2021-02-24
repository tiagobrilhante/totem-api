<?php

namespace Database\Seeders;

use App\Models\Om;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->insert([
            [
                'id' => 1,
                'type' => 'Administrador'
            ],
            [
                'id' => 2,
                'type' => 'Chamador'
            ]

        ]);
    }
}
