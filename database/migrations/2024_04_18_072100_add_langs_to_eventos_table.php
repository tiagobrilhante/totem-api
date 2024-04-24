<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLangsToEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->string('nome_es')->after('nome')->nullable();
            $table->string('nome_en')->after('nome')->nullable();
            $table->longText('legenda_es')->after('legenda')->nullable();
            $table->longText('legenda_en')->after('legenda')->nullable();
            $table->longText('saibamais_es')->after('saibamais')->nullable();
            $table->longText('saibamais_en')->after('saibamais')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            //
        });
    }
}
