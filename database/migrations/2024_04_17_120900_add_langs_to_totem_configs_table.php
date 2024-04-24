<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLangsToTotemConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('totem_configs', function (Blueprint $table) {
            $table->string('nome_totem_es')->after('nome_totem')->nullable();
            $table->string('nome_totem_en')->after('nome_totem')->nullable();
            $table->string('selected_lang')->after('nome_totem')->default('pt_br');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('totem_configs', function (Blueprint $table) {
            //
        });
    }
}
