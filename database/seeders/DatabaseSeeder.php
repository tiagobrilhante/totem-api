<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             OmSeeder::class,
             UserSeeder::class,
             PanelSeeder::class,
             GuicheSeeder::class,
             ChamadaNormalParametroSeeder::class,
             ChamadaPrioridadeParametroSeeder::class,
             TipoAtendimentoSeeder::class,
             ChamadaSeeder::class
         ]);
    }
}
