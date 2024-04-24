<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLangsToImagemEventoAdicionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imagem_evento_adicionals', function (Blueprint $table) {
            $table->longText('descricao_es')->after('descricao')->nullable();
            $table->longText('descricao_en')->after('descricao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imagem_evento_adicionals', function (Blueprint $table) {
            //
        });
    }
}
