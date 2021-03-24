<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaChamadaPrioridadeParametros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chamada_prioridade_parametros', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('numero_inicial');
            $table->date('data_ref');
            $table->string('responsavel');
            $table->string('validacao');

            $table->bigInteger('panel_id')->unsigned()->index();

            $table->foreign('panel_id')
                ->references('id')
                ->on('panels');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chamada_prioridade_parametros');
    }
}
